<?php
namespace App\Http\Controllers;

//  
use App\Events\NewChatMessage;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Pastikan ini di-import

class ChatController extends Controller
{
    public function sellerChat()
    {
        $user = auth()->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages' => function($query) {
                $query->latest()->limit(1); // Ambil pesan terakhir saja
            }])
            // Tambahkan pengurutan berdasarkan is_pinned (descending)
            ->orderBy('is_pinned', 'desc') //
            ->get();

        // Kemudian urutkan lagi di koleksi berdasarkan pesan terakhir, agar yang tidak di-pin tetap terurut dengan baik
        $conversations = $conversations->sortByDesc(function($conv) { //
            return optional($conv->messages->first())->created_at ?? $conv->created_at; //
        })->values(); //

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

    public function index(Request $request)
    {
        $user = auth()->user();

        $conversations = Conversation::where(function ($query) use ($user) {
                $query->where('user1_id', $user->id)
                      ->orWhere('user2_id', $user->id);
            })
            // Eager load messages agar tidak N+1 query, dan urutkan pesannya
            ->with(['user1', 'user2', 'messages' => function($query) {
                $query->latest()->limit(1); // Hanya ambil pesan terakhir untuk efisiensi
            }])
            // Tambahkan pengurutan ini
            ->orderBy('is_pinned', 'desc') //
            ->get();

        // Tambahkan pengurutan sekunder berdasarkan waktu pesan terakhir di koleksi
        // Tangani kasus di mana tidak ada pesan terakhir
        $conversations = $conversations->sortByDesc(function($conv) { //
            // Jika ada pesan terakhir, gunakan created_at-nya, jika tidak, gunakan created_at dari conversation
            return optional($conv->messages->first())->created_at ?? $conv->created_at; //
        })->values(); // Reset keys setelah sorting //


        $conversationUserIds = $conversations->pluck('user1_id')
            ->merge($conversations->pluck('user2_id'))
            ->unique()
            ->toArray();

        $availableUsersToChat = User::where('role', 'seller')
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $conversationUserIds)
            ->get();

        $activeConversation = null;
        if ($request->has('conversation_id')) {
            $activeConversation = Conversation::find($request->conversation_id);
            if (!$activeConversation || !in_array($user->id, [$activeConversation->user1_id, $activeConversation->user2_id])) {
                $activeConversation = null;
            }
        }
        if (!$activeConversation && $conversations->isNotEmpty()) {
            $activeConversation = $conversations->first(); // Ambil yang pertama setelah diurutkan
        }

        return view('view-customer.chat-customer', compact('user', 'conversations', 'availableUsersToChat', 'activeConversation'));
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

        // Pastikan validasi role ini benar-benar sesuai kebutuhan Anda.
        // Jika customer hanya bisa chat dengan seller, dan seller hanya dengan customer.
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

            // UBAH INI: Pastikan menggunakan event yang benar untuk broadcast ke channel percakapan
            // dan ini akan didengarkan oleh kedua belah pihak di channel PrivateChannel('chat.' . conversation_id)
            broadcast(new \App\Events\NewChatMessage($msg))->toOthers(); // Pastikan namespace benar

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

        // Gunakan NewChatMessage untuk konsistensi
        broadcast(new \App\Events\NewChatMessage($message))->toOthers();

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

    public function chatWithSellerRedirect(User $seller)
    {
        // Pastikan user yang di-request adalah seller
        if (!$seller->isSeller()) {
            abort(404, 'User is not a seller.');
        }

        $loggedInUser = Auth::user();

        // Pencegahan chat dengan diri sendiri
        if ($loggedInUser->id === $seller->id) {
            // Anda bisa mengarahkan ke halaman profil atau menampilkan pesan error
            return redirect()->route('chat-customer')->with('error', 'Tidak bisa chat dengan diri sendiri.');
        }

        // Pastikan yang chat adalah customer dengan seller
        if (!($loggedInUser->isCustomer())) {
            abort(403, 'Anda harus menjadi customer untuk memulai chat dengan seller.');
        }

        // Logika untuk membuat atau mendapatkan percakapan
        // Pastikan user1_id selalu lebih kecil dari user2_id untuk konsistensi
        [$u1, $u2] = [min($loggedInUser->id, $seller->id), max($loggedInUser->id, $seller->id)];

        $conversation = Conversation::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        // Redirect ke halaman chat-customer dengan parameter conversation_id
        // Halaman chat-customer akan membaca parameter ini untuk mengaktifkan chat yang sesuai
        return redirect()->route('chat-customer', ['conversation_id' => $conversation->id]);
    }

    public function pinConversation(Request $request, Conversation $conversation)
    {
        // Pastikan user yang login adalah bagian dari percakapan ini
        if (!in_array(Auth::id(), [$conversation->user1_id, $conversation->user2_id])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $isPinned = $request->input('is_pinned');

        $conversation->is_pinned = $isPinned;
        $conversation->save();

        $message = $isPinned ? 'Chat berhasil di-pin.' : 'Chat berhasil di-unpin.';

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Menghapus percakapan beserta semua pesannya.
     */
    public function deleteConversation(Conversation $conversation)
    {
        // Pastikan user yang login adalah bagian dari percakapan ini
        if (!in_array(Auth::id(), [$conversation->user1_id, $conversation->user2_id])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        DB::beginTransaction();
        try {
            // Hapus semua pesan yang terkait dengan percakapan ini
            Message::where('conversation_id', $conversation->id)->delete();

            // Hapus percakapan itu sendiri
            $conversation->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Chat berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menghapus chat: ' . $e->getMessage()], 500);
        }
    }

        public function markConversationAsRead(Conversation $conversation)
    {
        // Pastikan user yang login adalah bagian dari percakapan ini
        if (!in_array(Auth::id(), [$conversation->user1_id, $conversation->user2_id])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        try {
            $conversation->messages()
                ->where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return response()->json(['success' => true, 'message' => 'Pesan telah dibaca.']);
        } catch (\Exception $e) {
            \Log::error('Error marking conversation as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menandai pesan sebagai sudah dibaca.'], 500);
        }
    }

        public function getUnreadMessagesCount()
    {
        $userId = Auth::id();

        // Pastikan user sudah login
        if (!$userId) {
            // Mengembalikan 0 atau respons 401 Unauthorized jika user belum login
            return response()->json(['count' => 0], 200); // Mengembalikan 0 untuk mencegah error di frontend
            // return response()->json(['message' => 'Unauthorized'], 401); // Alternatif jika Anda ingin memberitahu frontend user tidak login
        }

        try {
            // Menghitung pesan yang belum dibaca untuk user yang sedang login
            $count = Message::where('receiver_id', $userId)
                            ->whereNull('read_at')
                            ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            // Log error ke storage/logs/laravel.log
            \Log::error('Error fetching unread count for user ' . $userId . ': ' . $e->getMessage());
            // Mengembalikan respons error JSON agar frontend tidak error "Unexpected token <"
            return response()->json(['success' => false, 'message' => 'Failed to fetch unread count.'], 500);
        }
    }

    public function sellerChatApi()
    {
        $user = auth()->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages' => function($query) {
                $query->latest()->limit(1); // Ambil pesan terakhir saja
            }])
            ->orderBy('is_pinned', 'desc') // Urutkan berdasarkan pin
            ->get();

        // Kemudian urutkan lagi di koleksi berdasarkan pesan terakhir, agar yang tidak di-pin tetap terurut dengan baik
        $conversations = $conversations->sortByDesc(function($conv) {
            return optional($conv->messages->first())->created_at ?? $conv->created_at;
        })->values();

        // Load profile picture URL for users in conversations
        $conversations->each(function ($conv) {
            $conv->user1->profile_picture_url = $conv->user1->profile_picture_url ?? asset('path/to/default/profile_picture.jpg'); // Ganti dengan path default Anda
            $conv->user2->profile_picture_url = $conv->user2->profile_picture_url ?? asset('path/to/default/profile_picture.jpg'); // Ganti dengan path default Anda
        });

        return response()->json(['conversations' => $conversations]);
    }   

    public function getUserStatus(User $user)
    {
        // Asumsi Anda memiliki metode `isOnline()` di model User
        // atau Anda bisa memeriksa kolom `last_seen` jika ada
        return response()->json(['is_online' => $user->isOnline()]);
    }

}