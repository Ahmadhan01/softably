<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- TAMBAHKAN BARIS INI

class Message extends Model
{
    use HasFactory; // Pastikan use HasFactory ada di sini

    protected $fillable = ['sender_id', 'receiver_id', 'conversation_id', 'content'];

    public function sender(): BelongsTo // Ini sekarang akan dikenali
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver(): BelongsTo // Ubah ini juga agar konsisten
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}