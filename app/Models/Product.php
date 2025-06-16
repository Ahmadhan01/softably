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
}