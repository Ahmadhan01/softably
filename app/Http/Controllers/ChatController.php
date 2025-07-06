<?php

namespace App\Http\Controllers;

    use App\Models\Conversation; // Jika Anda menggunakan Conversation model
    use App\Models\Message;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Events\NewChatMessage; // Jika Anda menggunakan event ini untuk chat lain
    use App\Events\MessageSent; // Event yang baru kita perbarui

    class ChatController extends Controller
    {
      
        public function sellerChat()
    {
        $user = auth()->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages'])
            ->latest()
            ->get();

        $conversationUserIds = $conversations->pluck('user1_id')
            ->merge($conversations->pluck('user2_id'))
            ->unique()
            ->toArray();

        $availableUsersToChat = User::where('role', 'customer')
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $conversationUserIds)
            ->get();

        return view('view-seller.chat-seller', compact('user', 'conversations', 'availableUsersToChat'));
    }


    public function index()
    {
        $user = auth()->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages'])
            ->get();

        $conversationUserIds = $conversations->pluck('user1_id')
            ->merge($conversations->pluck('user2_id'))
            ->unique()
            ->toArray();

        $availableUsersToChat = User::where('role', 'seller')
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $conversationUserIds)
            ->get();

        return view('view-customer.chat-customer', compact('user', 'conversations', 'availableUsersToChat'));
    }

    public function getMessages(Conversation $conversation)
{
    $authId = Auth::id();

    // Validasi partisipasi
    if (!in_array($authId, [$conversation->user1_id, $conversation->user2_id])) {
        abort(403, 'Unauthorized access to conversation');
    }

    // Tandai pesan masuk sebagai read
    $conversation->messages()
        ->where('sender_id', '!=', $authId)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    return response()->json([
        'messages'  => $conversation->messages()->with('sender:id,name,username')->get(),
        'otherUser' => $conversation->otherUser($authId, ['id', 'name', 'username']),
    ]);
}



    public function sendMessage(Request $r, Conversation $conversation)
    {
        $r->validate(['content' => 'required|string|max:1000']);
        abort_unless($conversation->participants->contains(Auth::id()), 403);

        $loggedInUser = Auth::user();
        $otherUser = $conversation->otherUser($loggedInUser->id);

        if (!$otherUser) {
            return response()->json(['success' => false, 'message' => 'Other user not found.'], 422);
        }

        if (($loggedInUser->isCustomer() && !$otherUser->isSeller()) ||
            ($loggedInUser->isSeller() && !$otherUser->isCustomer())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized chat partner.'], 403);
        }

        try {
            $msg = $conversation->messages()->create([
                'sender_id' => Auth::id(),
                'receiver_id' => $otherUser->id,
                'content' => $r->content,
            ]);

            broadcast(new NewChatMessage($msg))->toOthers();

            return response()->json(['success' => true, 'message' => $msg->load('sender:id,name,username')]);
        } catch (\Exception $e) {
            \Log::error('Send message error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }

    public function createOrGetConversation(Request $r)
    {
        $r->validate(['other_user_id' => 'required|exists:users,id|different:' . Auth::id()]);

        $loggedInUser = Auth::user();
        $otherUser = User::find($r->other_user_id);

        if (($loggedInUser->isCustomer() && !$otherUser->isSeller()) ||
            ($loggedInUser->isSeller() && !$otherUser->isCustomer())) {
            return response()->json(['success' => false, 'message' => 'Cannot start chat with this user role.'], 403);
        }

        [$u1, $u2] = [min(Auth::id(), $r->other_user_id), max(Auth::id(), $r->other_user_id)];

        $conversation = Conversation::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        return response()->json(['conversation_id' => $conversation->id]);
    }


        // Customer to Admin Chat
        public function fetchMessagesWithAdmin()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            \Log::error('Admin user not found for chat.');
            return response()->json(['error' => 'Admin not found'], 404);
        }
        $messages = Message::where(function ($q) use ($admin) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $admin->id);
        })->orWhere(function ($q) use ($admin) {
            $q->where('sender_id', $admin->id)
              ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

        public function sendMessageToAdmin(Request $request)
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            \Log::error('Admin user not found for sending message.');
            return response()->json(['error' => 'Admin not found'], 404);
        }
        $request->validate(['message' => 'required|string|max:1000']);
        try {
            $message = Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $admin->id,
                'content' => $request->message,
            ]);
            // PENTING: Panggil event MessageSent dengan receiver_id dan sender_id yang benar
            // receiver_id adalah admin->id, sender_id adalah auth()->id() (customer)
            broadcast(new MessageSent($message, $admin->id, auth()->id()))->toOthers();
            return response()->json($message);
        } catch (\Exception $e) {
            \Log::error('Failed to send message to admin: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }

        // Admin to Customer Chat
        public function getCustomerListForAdmin()
        {
            $adminId = auth()->id();
            $customerIds = Message::where('receiver_id', $adminId)
                                   ->orWhere('sender_id', $adminId)
                                   ->whereHas('sender', function($query) {
                                       $query->where('role', 'customer');
                                   })
                                   ->orWhereHas('receiver', function($query) {
                                       $query->where('role', 'customer');
                                   })
                                   ->pluck('sender_id')
                                   ->merge(Message::where('receiver_id', $adminId)
                                                   ->orWhere('sender_id', $adminId)
                                                   ->pluck('receiver_id'))
                                   ->unique()
                                   ->filter(function($id) use ($adminId) {
                                       return $id != $adminId;
                                   });

            $customers = User::whereIn('id', $customerIds)
                             ->where('role', 'customer')
                             ->select('id', 'name')
                             ->get();

            return response()->json($customers);
        }

        public function fetchMessagesWithCustomer($id)
        {
            $adminId = auth()->id();
            $customerId = $id;

            $customer = User::where('id', $customerId)->where('role', 'customer')->first();
            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            $messages = Message::where(function ($q) use ($adminId, $customerId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $customerId);
            })->orWhere(function ($q) use ($adminId, $customerId) {
                $q->where('sender_id', $customerId)
                  ->where('receiver_id', $adminId);
            })->orderBy('created_at', 'asc')->get();

            return response()->json($messages);
        }

        public function sendMessageToCustomer(Request $request, $id)
    {
        $customerId = $id;
        $adminId = auth()->id(); // Admin yang sedang login
        $customer = User::where('id', $customerId)->where('role', 'customer')->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        $request->validate(['message' => 'required|string|max:1000']);
        try {
            $message = Message::create([
                'sender_id' => $adminId,
                'receiver_id' => $customerId,
                'content' => $request->message,
            ]);
            // PENTING: Panggil event MessageSent dengan receiver_id dan sender_id yang benar
            // receiver_id adalah customerId, sender_id adalah adminId
            broadcast(new MessageSent($message, $customerId, $adminId))->toOthers();
            return response()->json($message);
        } catch (\Exception $e) {
            \Log::error('Failed to send message to customer: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }
    }
    