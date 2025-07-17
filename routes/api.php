<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Models\User;

// Ganti kembali 'auth' menjadi 'auth:sanctum' di sini
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ganti kembali 'auth' menjadi 'auth:sanctum' di sini
Route::middleware('auth:sanctum')->group(function () { // UBAH INI
    // Rute API untuk daftar percakapan seller
    Route::get('/seller/chat/conversations', [ChatController::class, 'sellerChatApi'])->name('api.seller.chat.conversations');

    // Rute untuk pin/unpin chat
    Route::post('/chat/pin/{conversation}', [ChatController::class, 'pinConversation'])->name('api.chat.pin');

    // Rute untuk delete chat
    Route::delete('/chat/conversations/{conversation}', [ChatController::class, 'deleteConversation'])->name('api.chat.delete');

    // Rute chat yang mengembalikan JSON (dipindahkan dari web.php)
    Route::post('/chat/mark-as-read/{conversation}', [ChatController::class, 'markConversationAsRead'])->name('api.chat.markAsRead');
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadMessagesCount'])->name('api.chat.unreadCount');
    Route::post('/chat/create-or-get-conversation', [ChatController::class, 'createOrGetConversation'])->name('api.chat.createOrGetConversation');
    Route::get('/chat/messages/{conversation}', [ChatController::class, 'getMessages'])->name('api.chat.getMessages');
    Route::post('/chat/send/{conversation}', [ChatController::class, 'sendMessage'])->name('api.chat.sendMessage');

    // Rute user status (penting untuk fungsionalitas online/offline)
    Route::get('/user-status/{user}', function (User $user) {
        return response()->json(['is_online' => $user->isOnline()]);
    })->name('api.user.status');

    // Rute API untuk Info Seller (sudah ada di web.php Anda, pindahkan ke sini)
    Route::get('/seller-info/{user}', function (User $user) {
        if ($user->role !== 'seller') {
            return response()->json(['success' => false, 'message' => 'User bukan seller.'], 404);
        }
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'profile_picture_url' => $user->profile_picture_url,
                'is_online' => $user->isOnline(),
                'description' => $user->store_description,
            ],
        ]);
    })->name('api.seller.info');

    // Admin chat API routes (dipindahkan dari web.php)
    Route::get('/admin/chat/users', [ChatController::class, 'getChatUsersForAdmin'])->name('api.admin.chat.users');
    Route::get('/admin/chat/messages/{id}', [ChatController::class, 'fetchMessagesWithUser'])->name('api.admin.chat.messages');
    Route::post('/admin/chat/send/{id}', [ChatController::class, 'sendMessageToUser'])->name('api.admin.chat.send');
    Route::get('/chat/admin/messages', [ChatController::class, 'fetchMessagesWithAdmin'])->name('api.customer.chat.messages');
    Route::post('/chat/admin/send', [ChatController::class, 'sendMessageToAdmin'])->name('api.customer.chat.send');

    // >> TEST-AUTH JUGA KEMBALI KE 'auth:sanctum' <<
    Route::get('/test-auth', function (Request $request) {
        return response()->json(['message' => 'Anda terotentikasi!', 'user' => $request->user()]);
    })->middleware('auth:sanctum'); // Tambahkan middleware Sanctum lagi jika Anda menguji rute ini secara terpisah.
});