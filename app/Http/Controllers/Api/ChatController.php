<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User; // Perlu untuk mendapatkan info user
use App\Models\Product; // Perlu untuk mendapatkan info produk
use Illuminate\Support\Facades\DB; // Untuk raw queries jika diperlukan
use Illuminate\Support\Carbon; // Untuk datetime

class ChatController extends Controller
{
    // ASUMSI: Mendapatkan ID Seller yang sedang login (Contoh: dari JWT/Sanctum Token, atau hardcode untuk demo)
    private $sellerId = 3; // Ganti dengan ID seller yang login di sistem Anda

    /**
     * Get list of conversations for the seller.
     */
    public function getChats(Request $request)
    {
        // Ambil semua percakapan di mana seller adalah salah satu peserta
        $conversations = Conversation::with(['user1', 'user2', 'lastMessage'])
                            ->where('user1_id', $this->sellerId)
                            ->orWhere('user2_id', $this->sellerId)
                            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan yang paling baru diupdate
                            ->get();

        $chatsData = [];

        foreach ($conversations as $conversation) {
            // Tentukan siapa partisipan lawan bicara
            $participant = ($conversation->user1_id == $this->sellerId) ? $conversation->user2 : $conversation->user1;

            // Ambil pesan terakhir
            $lastMessage = $conversation->lastMessage;
            $lastMessageContent = $lastMessage ? $lastMessage->content : 'Start a conversation';
            $lastMessageTime = $lastMessage ? Carbon::parse($lastMessage->created_at)->format('h:i A') : '';

            // Tentukan status online/offline
            $status = 'offline';
            if ($participant->last_seen && Carbon::parse($participant->last_seen)->diffInMinutes(Carbon::now()) < 5) {
                $status = 'online';
            }

            // --- BAGIAN KRITIS: Menghubungkan Chat ke Produk ---
            // Di softably.sql, conversations tidak langsung terhubung ke products.
            // Anda perlu logika untuk menentukan produk mana yang relevan dengan chat ini.
            // Misal: Anda bisa menyimpan `product_id` di tabel `conversations` atau `messages`
            // jika setiap percakapan selalu tentang satu produk.
            // Untuk DEMO, kita akan mencoba mengambil produk dari transaksi terakhir user lawan chat.
            $productName = 'Produk Tidak Diketahui';
            $productImage = '/img/icon-soft.png';
            $productDate = 'Tanggal tidak diketahui';
            $productDetails = 'Detail produk ini tidak tersedia di mock data.';

            // Logika ini masih tebakan berdasarkan `softably.sql` dan frontend Anda.
            // Lebih baik jika ada kolom `product_id` di tabel `conversations`.
            $latestTransactionDetail = DB::table('transactions')
                ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                ->where('transactions.user_id', $participant->id)
                ->latest('transactions.created_at')
                ->select('transaction_details.product_id', 'transactions.created_at')
                ->first();

            if ($latestTransactionDetail && $latestTransactionDetail->product_id) {
                $product = Product::find($latestTransactionDetail->product_id);
                if ($product) {
                    $productName = $product->name;
                    $productImage = $product->image_path ? '/' . $product->image_path : '/img/icon-soft.png';
                    $productDate = Carbon::parse($latestTransactionDetail->created_at)->format('j-n-Y');
                    $productDetails = $product->description ?? $productDetails; // Gunakan deskripsi produk dari DB
                }
            }
            // --- AKHIR BAGIAN KRITIS ---

            $chatsData[] = [
                'id' => 'chat_' . $conversation->id, // ID untuk frontend
                'conversation_id_db' => $conversation->id, // ID asli dari DB
                'participant_id' => $participant->id,
                'name' => $participant->name,
                'avatar' => $participant->profile_picture ? '/' . $participant->profile_picture : '/img/default_avatar.png',
                'lastMessage' => Str::limit($lastMessageContent, 30, '...'), // Menggunakan Str::limit Laravel
                'lastMessageTime' => $lastMessageTime,
                'status' => $status,
                'productName' => $productName,
                'productDate' => $productDate,
                'productImage' => $productImage,
                'details' => $productDetails,
            ];
        }

        return response()->json(['success' => true, 'chats' => $chatsData]);
    }

    /**
     * Get messages for a specific conversation.
     */
    public function getMessages(Request $request, $conversationId)
    {
        $messages = Message::with(['sender', 'receiver'])
                            ->where('conversation_id', $conversationId)
                            ->orderBy('created_at', 'asc')
                            ->get();

        $messagesData = [];
        foreach ($messages as $message) {
            $senderName = ($message->sender_id == $this->sellerId) ? 'You' : $message->sender->name;
            $messageTime = Carbon::parse($message->created_at)->format('h:i A');

            $dateDisplay = 'Tanggal tidak diketahui';
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();

            if (Carbon::parse($message->created_at)->isToday()) {
                $dateDisplay = 'Hari ini';
            } elseif (Carbon::parse($message->created_at)->isYesterday()) {
                $dateDisplay = 'Kemarin';
            } else {
                $dateDisplay = Carbon::parse($message->created_at)->format('j M');
            }

            $messagesData[] = [
                'sender' => $senderName,
                'time' => $messageTime,
                'date' => $dateDisplay,
                'text' => $message->content,
                // Tambahkan properti untuk lampiran jika Anda implementasi di masa depan
                // 'type' => 'text',
                // 'fileName' => null,
                // 'url' => null,
                // 'isImage' => false,
            ];
        }

        return response()->json(['success' => true, 'messages' => $messagesData]);
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => $this->sellerId,
            'receiver_id' => $request->receiver_id,
            'content' => $request->message,
            'read_at' => null, // Atur menjadi null saat dikirim
        ]);

        // Update updated_at di tabel conversations agar chat naik ke atas
        Conversation::where('id', $request->conversation_id)->update(['updated_at' => Carbon::now()]);

        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim.', 'data' => $message]);
    }
}