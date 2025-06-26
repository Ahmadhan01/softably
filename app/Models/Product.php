<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Sesuaikan dengan kolom-kolom di tabel 'products' Anda
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category',
        'status',
        // Tambahkan kolom lain jika Anda perlu menyimpannya dari form Add Product
        'views', // Jika kolom ini ada di DB
        'rating', // Jika kolom ini ada di DB
        'sold', // Jika kolom ini ada di DB
        'wish', // Jika kolom ini ada di DB
        'cart', // Jika kolom ini ada di DB
    ];
    // Pastikan nama tabel benar jika tidak 'products'
    // protected $table = 'nama_tabel_produk';
}