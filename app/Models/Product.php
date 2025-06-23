<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path', // Ini adalah nama kolom di database Anda
        'category',
        'download_link', // <== TAMBAHKAN INI
        'content_description', // <== TAMBAHKAN INI
        'status',
        // 'sales_count',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor untuk URL gambar produk
    public function getImageUrlAttribute() // Accessor akan membuat properti 'image_url' tersedia
    {
        // Panggil kolom yang benar, yaitu $this->image_path
        if ($this->image_path) {
            // Pertama, coba asumsikan itu adalah URL eksternal atau URL Storage
            if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
                return $this->image_path; // Jika sudah URL lengkap, langsung kembalikan
            }
            // Jika bukan URL lengkap, cek apakah itu adalah path yang tersimpan di storage/app/public
            // Misalnya: 'product_images/xyz.jpg' (setelah php artisan storage:link)
            if (Storage::disk('public')->exists($this->image_path)) {
                return Storage::url($this->image_path);
            }
            // Jika tidak di storage/app/public, asumsikan itu adalah path relatif ke folder public
            // Misalnya: 'img/novel.png' atau 'assets/gambar.jpg'
            return asset($this->image_path);
        }
        // Fallback ke gambar default jika image_path kosong atau tidak ada file ditemukan
        return asset('img/default-product.jpg'); // Pastikan Anda memiliki gambar default ini
    }

    // Relasi ke Comments
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