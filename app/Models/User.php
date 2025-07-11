<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens; // Mengaktifkan HasApiTokens jika Anda memakainya

    // use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'username',
        'role',
        'phone_number',
        'profile_picture', // Pastikan ini ada dan diizinkan untuk diisi
        'password',
        'date_of_birth',
        'country',
        

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen' => 'datetime',
    ];

    public function isOnline()

    {
        return $this->last_seen && $this->last_seen->gt(now()->subMinutes(5));
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function hasInWishlist(int $productId): bool
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function hasInCart(int $productId): bool
    {
        return $this->carts()->where('product_id', $productId)->exists();
    }

    public function conversationsAsUser1(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user1_id');
    }

    public function conversationsAsUser2(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user2_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function allConversations()
    {
        return $this->conversationsAsUser1->merge($this->conversationsAsUser2);
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Perbaikan pada Accessor getProfilePictureUrlAttribute
    public function getProfilePictureUrlAttribute(): string
    {
        if ($this->profile_picture) {
            // 1. Cek apakah ini URL eksternal
            if (filter_var($this->profile_picture, FILTER_VALIDATE_URL)) {
                return $this->profile_picture;
            }
            // 2. Cek apakah file ada di storage/app/public
            if (Storage::disk('public')->exists($this->profile_picture)) {
                // Tambahkan timestamp untuk mencegah caching pada browser saat gambar diupdate
                return Storage::url($this->profile_picture) . '?' . now()->timestamp;
            }
            // 3. Asumsikan ini adalah path relatif ke folder public
            // Tambahkan timestamp juga untuk ini
            return asset($this->profile_picture) . '?' . now()->timestamp;
        }

        // Fallback jika tidak ada foto profil atau file tidak ditemukan
        return asset('img/default-profile.png'); // Pastikan Anda memiliki gambar ini
    }

    public function purchasedProducts(): HasManyThrough
    {
        return $this->hasManyThrough(TransactionDetail::class, Transaction::class);
    }

    // Tambahkan relasi ini untuk produk yang dimiliki oleh user ini sebagai seller
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }
}