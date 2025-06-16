<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Search Product
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // 2. Filter Harga
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', (float)$request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', (float)$request->max_price);
        }

        // 3. Sorting
        switch ($request->sort_by) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'best_seller': // Anda perlu menambahkan kolom 'sales_count' atau sejenisnya di tabel products
                $query->orderBy('sales_count', 'desc'); // Contoh
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sort
                break;
        }

        // 4. Menampilkan produk dari beberapa produk (Pagination)
        // Adjust per page as needed
        $products = $query->paginate(15); // Menampilkan 15 produk per halaman

        // Jika request datang dari AJAX untuk tampilan mode, kita bisa return JSON
        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(), // Hanya item produk
                'pagination' => (string) $products->links(), // Render pagination links
            ]);
        }

        return view('view-customer.produk-customer', compact('products'));
    }

    // Metode untuk menambah produk (dari pembahasan sebelumnya, bisa dihapus/diabaikan jika tidak dipakai)
    public function addOneProduct()
    {
        // Contoh data produk untuk testing
        $productsData = [
            ['name' => 'Novel Hujan', 'description' => 'Sebuah novel fiksi ilmiah romantis karya Tere Liye tentang kisah cinta di tengah hujan.', 'price' => 75000.00],
            ['name' => 'Buku Resep Masakan Nusantara', 'description' => 'Kumpulan resep masakan tradisional Indonesia dari berbagai daerah.', 'price' => 120000.00],
            ['name' => 'E-Book Panduan Investasi', 'description' => 'Panduan lengkap untuk pemula di dunia investasi saham dan reksadana.', 'price' => 45000.00],
            ['name' => 'Template Presentasi Powerpoint Modern', 'description' => 'Kumpulan template profesional untuk presentasi bisnis dan pendidikan.', 'price' => 85000.00],
            ['name' => 'Course Desain Grafis Pemula', 'description' => 'Video tutorial interaktif untuk mempelajari dasar-dasar desain grafis.', 'price' => 250000.00],
            ['name' => 'Audiobook Self-Improvement', 'description' => 'Koleksi audiobook untuk pengembangan diri dan motivasi.', 'price' => 60000.00],
            ['name' => 'Vector Icon Pack Premium', 'description' => 'Paket ikon vektor berkualitas tinggi untuk web dan aplikasi.', 'price' => 90000.00],
            ['name' => 'Software Video Editing Portable', 'description' => 'Aplikasi editing video ringan yang bisa dijalankan tanpa instalasi.', 'price' => 180000.00],
            ['name' => 'Template Website HTML/CSS', 'description' => 'Template siap pakai untuk membuat website personal atau bisnis kecil.', 'price' => 110000.00],
            ['name' => 'Preset Lightroom Pack', 'description' => 'Koleksi preset untuk editing foto profesional di Adobe Lightroom.', 'price' => 50000.00],
            ['name' => 'Asset Game 2D Fantasy', 'description' => 'Kumpulan aset grafis untuk pengembangan game 2D bergenre fantasi.', 'price' => 200000.00],
            ['name' => 'Modul Belajar Coding Python', 'description' => 'Modul interaktif untuk belajar pemrograman Python dari dasar hingga mahir.', 'price' => 150000.00],
            ['name' => 'Font Pack Kreatif', 'description' => 'Koleksi font unik dan kreatif untuk proyek desain Anda.', 'price' => 30000.00],
            ['name' => 'Mockup Desain Produk 3D', 'description' => 'Mockup 3D realistis untuk presentasi desain produk Anda.', 'price' => 70000.00],
            ['name' => 'Kumpulan Sound Effect Cinematic', 'description' => 'Efek suara berkualitas tinggi untuk produksi video dan film.', 'price' => 100000.00],
        ];

        foreach ($productsData as $data) {
            Product::create($data);
        }

        return "Produk '" . count($productsData) . "' berhasil ditambahkan untuk testing!";
    }
}