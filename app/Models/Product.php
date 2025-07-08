<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category',
        'product_link',
        'currency',
        'download_link',
        'content_description',
        'status',
        'user_id', // Pastikan user_id ada di fillable jika diatur langsung
    ];
    

    // Relasi ke User (seller yang punya produk ini)
    public function user(): BelongsTo // Ganti seller() menjadi user() agar konsisten dengan User::products()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
        // 1. Cek apakah ini URL eksternal (misalnya dari social login atau placeholder)
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // 2. Coba bangun URL menggunakan 'storage/' prefix, sesuai dengan cara di viewproduk-customer.blade.php
        // Ini mengasumsikan file ada di public/storage/ atau public/
        $potentialAssetPath = 'storage/' . $this->image_path;
        if (file_exists(public_path($potentialAssetPath))) {
            return asset($potentialAssetPath);
        }

        // 3. Jika tidak ditemukan dengan prefix 'storage/', coba tanpa prefix (misal: img/novel.png)
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }
        
        // 4. Fallback ke Storage::url() jika gambar diunggah ke storage/app/public
        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::url($this->image_path);
        }
    }

    // 5. Fallback jika tidak ada image_path atau file tidak ditemukan di semua lokasi yang dicoba
    return asset('img/default-product.jpg');
    }

    // Relasi ke komentar
    // public function comments(): HasMany
    // {
    //     return $this->hasMany(Comment::class)->whereNull('parent_id'); // Hanya komentar utama
    // }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke wishlist
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relasi ke cart
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi ke detail transaksi (untuk menghitung produk terjual)
    public function orderItems(): HasMany // Menggunakan orderItems karena produk ada di TransactionDetail
    {
        return $this->hasMany(TransactionDetail::class); // Asumsi nama model TransactionDetail
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function seller()
{
    return $this->belongsTo(User::class, 'user_id');
}
}