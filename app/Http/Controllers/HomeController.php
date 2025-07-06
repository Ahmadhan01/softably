<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 produk terlaris berdasarkan sales_count
        // Urutkan dari sales_count tertinggi ke terendah
        $bestSellingProducts = Product::orderByDesc('sales_count')
                                      ->limit(3) // Ambil 3 produk teratas
                                      ->get();

        // Jika kurang dari 3 produk terlaris, Anda bisa menambahkan produk lain secara acak
        // atau produk terbaru sebagai fallback
        if ($bestSellingProducts->count() < 3) {
            $fallbackProducts = Product::whereNotIn('id', $bestSellingProducts->pluck('id'))
                                       ->latest() // Ambil yang terbaru
                                       ->limit(3 - $bestSellingProducts->count())
                                       ->get();
            $bestSellingProducts = $bestSellingProducts->merge($fallbackProducts);
        }

        // Pastikan kita hanya punya 3 produk untuk ditampilkan di carousel
        $bestSellingProducts = $bestSellingProducts->take(3);


        return view('landing-page', compact('bestSellingProducts'));
    }
}