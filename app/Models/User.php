<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Pastikan ini tidak diimport jika tidak menggunakan Sanctum

class User extends Authenticatable // implements MustVerifyEmail // Uncomment jika menggunakan verifikasi email
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username', // Pastikan ini ada jika Anda menggunakannya
        'email',
        'password',
        'role', // Jika ada kolom role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    // Helper untuk mengecek apakah produk ada di wishlist user
    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    // Helper untuk mengecek apakah produk ada di cart user
    public function hasInCart($productId)
    {
        return $this->carts()->where('product_id', $productId)->exists();
    }
}