<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'content',
        'parent_id', // <== TAMBAHKAN INI UNTUK BALASAN
    ];

    // Relasi ke User (komentar ini milik user siapa)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product (komentar ini untuk produk mana)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke komentar induk (jika ini adalah balasan)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi ke balasan (jika komentar ini memiliki balasan)
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}