<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use App\Models\User;

Broadcast::channel('chat.{conversation}', function ($user, Conversation $conversation) {
    // Autorisasi: user harus peserta percakapan
    // Dan pastikan user yang berkomunikasi adalah customer <-> seller
    $otherUser = $conversation->otherUser($user->id);

    if (!$otherUser) {
        return false; // Partner tidak ditemukan
    }

    // Pastikan salah satu user adalah customer dan yang lain adalah seller
    $isCustomerSellerChat = ($user->isCustomer() && $otherUser->isSeller()) ||
                            ($user->isSeller() && $otherUser->isCustomer());

    return $conversation->participants->contains($user->id) && $isCustomerSellerChat;
});

// Presence channel untuk melacak pengguna online (misalnya, semua customer dan seller)
Broadcast::channel('presence-chat', function ($user) {
    // Hanya izinkan customer dan seller untuk bergabung ke presence channel ini
    if ($user->isCustomer() || $user->isSeller()) {
        return [
            'id' => $user->id,
            'name' => $user->name, // Atau informasi pengguna
        ];
    }
    return false;
});