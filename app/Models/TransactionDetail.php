<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage; // <== TAMBAHKAN INI

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'product_image_path', // <== PASTIKAN INI ADA DI FILLABLE
        'price',
        'quantity',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor untuk mendapatkan URL gambar produk yang dibeli
    public function getProductImageUrlAttribute()
    {
        // Asumsi product_image di TransactionDetail menyimpan path relatif
        if ($this->product_image && Storage::disk('public')->exists($this->product_image)) {
            return Storage::url($this->product_image);
        }
        // Fallback ke gambar dari relasi produk (jika masih ada) atau default
        return $this->product->image_path ?? asset('img/default-product.jpg'); // Menggunakan image_url dari Product
    }
}