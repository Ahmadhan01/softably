<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        // Tambahkan kolom 'sales_count' di sini jika Anda menggunakannya untuk 'best_seller'
        // 'sales_count',
    ];

    // Relasi ke Comments (sudah ada)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke Wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relasi ke Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Pastikan ada relasi user di model Comment jika belum ada
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}