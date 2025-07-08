<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Events\MessageSent;


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
    // $conversation->messages()
    //     ->where('sender_id', '!=', $authId)
    //     ->whereNull('read_at')
    //     ->update(['read_at' => now()]);

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

    // customer to admin

     public function fetchMessagesWithAdmin()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) return response()->json(['error' => 'Admin not found'], 404);

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
        if (!$admin) return response()->json(['error' => 'Admin not found'], 404);

        $request->validate(['message' => 'required|string']);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $admin->id,
            'content' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();
        event(new \App\Events\MessageSent($message));

        return response()->json($message);
    }


        public function getCustomerListForAdmin()
    {
        $customers = User::where('role', 'customer')->select('id', 'name')->get();
        return response()->json($customers);
    }

    public function fetchMessagesWithCustomer($id)
    {
        $messages = Message::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())
            ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)
            ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function sendMessageToCustomer(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        $message = Message::create([
            'sender_id' => auth()->id(),     // admin
            'receiver_id' => $id,            // customer yang dipilih
            'content' => $request->message,
        ]);

        return response()->json($message);
    }
    public function getUnreadMessagesCount()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['count' => 0]);
        }

        // Menghitung pesan masuk yang belum dibaca (read_at is NULL)
        $unreadCount = Message::where('receiver_id', $userId)
                              ->whereNull('read_at')
                              ->count();

        return response()->json(['count' => $unreadCount]);
    }

    /**
     * Menandai semua pesan dalam suatu percakapan sebagai sudah dibaca
     * untuk user yang sedang login.
     */
    public function markConversationAsRead(Conversation $conversation)
    {
        $userId = Auth::id();

        // Pastikan user adalah peserta dari percakapan ini
        if (!in_array($userId, [$conversation->user1_id, $conversation->user2_id])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Tandai semua pesan yang diterima oleh user ini dalam percakapan ini sebagai dibaca
        $conversation->messages()
                     ->where('receiver_id', $userId)
                     ->whereNull('read_at')
                     ->update(['read_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Conversation marked as read.']);
    }
}
