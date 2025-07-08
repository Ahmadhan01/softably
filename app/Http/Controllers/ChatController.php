<?php
namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\NewChatMessage;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Pastikan ini di-import

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

        if (! in_array($authId, [$conversation->user1_id, $conversation->user2_id])) {
            abort(403, 'Unauthorized access to conversation');
        }

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
        $otherUser    = $conversation->otherUser($loggedInUser->id);

        if (! $otherUser) {
            return response()->json(['success' => false, 'message' => 'Other user not found.'], 422);
        }

        if (($loggedInUser->isCustomer() && ! $otherUser->isSeller()) ||
            ($loggedInUser->isSeller() && ! $otherUser->isCustomer())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized chat partner.'], 403);
        }

        try {
            $msg = $conversation->messages()->create([
                'sender_id'   => Auth::id(),
                'receiver_id' => $otherUser->id,
                'content'     => $r->content,
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
        $otherUser    = User::find($r->other_user_id);

        if (($loggedInUser->isCustomer() && ! $otherUser->isSeller()) ||
            ($loggedInUser->isSeller() && ! $otherUser->isCustomer())) {
            return response()->json(['success' => false, 'message' => 'Cannot start chat with this user role.'], 403);
        }

        [$u1, $u2] = [min(Auth::id(), $r->other_user_id), max(Auth::id(), $r->other_user_id)];

        $conversation = Conversation::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        return response()->json(['conversation_id' => $conversation->id]);
    }

    // Modified to allow both customer and seller to chat with admin
    public function fetchMessagesWithAdmin()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $messages = Message::where(function ($q) use ($admin) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $admin->id);
        })
            ->orWhere(function ($q) use ($admin) {
                $q->where('sender_id', $admin->id)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Modified to allow both customer and seller to send messages to admin
    public function sendMessageToAdmin(Request $request)
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            \Log::error('Admin user not found for sending message.');
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $request->validate(['message' => 'required|string|max:1000']);

        try {
            $message = Message::create([
                'sender_id'   => auth()->id(),
                'receiver_id' => $admin->id,
                'content'     => $request->message,
            ]);

            // Broadcast to both sender and receiver channels
            // Menggunakan MessageSent event yang sudah ada
            broadcast(new MessageSent($message, $admin->id, auth()->id()))->toOthers();

            return response()->json($message);
        } catch (\Exception $e) {
            \Log::error('Failed to send message to admin: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }

    // Modified to get both customers and sellers who have chatted with admin
    public function getChatUsersForAdmin()
    {
        $adminId = auth()->id();

        $userIds = Message::where(function ($q) use ($adminId) {
            $q->where('receiver_id', $adminId)
                ->orWhere('sender_id', $adminId);
        })->pluck('sender_id')
            ->merge(Message::where('receiver_id', $adminId)
                    ->orWhere('sender_id', $adminId)
                    ->pluck('receiver_id'))
            ->unique()
            ->filter(function ($id) use ($adminId) {
                return $id != $adminId;
            });

        $users = User::whereIn('id', $userIds)
            ->whereIn('role', ['customer', 'seller']) // Include sellers
            ->select('id', 'name', 'role')            // Select role to differentiate
            ->get();

        return response()->json($users);
    }

    // Modified to fetch messages with any user (customer or seller)
    public function fetchMessagesWithUser($id)
    {
        $adminId   = auth()->id();
        $otherUser = User::where('id', $id)->whereIn('role', ['customer', 'seller'])->first();

        if (! $otherUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $messages = Message::where(function ($q) use ($adminId, $id) {
            $q->where('sender_id', $adminId)
                ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($adminId, $id) {
            $q->where('sender_id', $id)
                ->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // Modified to send messages to any user (customer or seller)
    public function sendMessageToUser(Request $request, $id)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $id,
            'content'     => $request->message,
        ]);

        // Hitung unread count terbaru
        $unreadCount = Message::where('receiver_id', $id)
            ->whereNull('read_at')
            ->count();

        broadcast(new MessageSent($message, $id, auth()->id(), $unreadCount));

        return response()->json($message);
    }

}
