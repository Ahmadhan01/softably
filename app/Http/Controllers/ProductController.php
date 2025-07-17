<?php
namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Search Product
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

                                                                              // 2. Filter Harga (PERUBAHAN DI SINI)
        if ($request->has('price_range') && $request->price_range != 'all') { // Cek price_range, bukan min/max_price
            $priceRange = $request->price_range;
            switch ($priceRange) {
                case '0-50000':
                    $query->whereBetween('price', [0, 50000]);
                    break;
                case '50000-100000':
                    $query->whereBetween('price', [50000, 100000]);
                    break;
                case '100000-500000':
                    $query->whereBetween('price', [100000, 500000]);
                    break;
                case '500000-max':
                    $query->where('price', '>=', 500000);
                    break;
            }
        }
        // Hapus kode lama untuk min_price dan max_price jika tidak lagi digunakan
        // if ($request->has('min_price') && $request->min_price != '') {
        //     $query->where('price', '>=', (float)$request->min_price);
        // }
        // if ($request->has('max_price') && $request->max_price != '') {
        //     $query->where('price', '<=', (float)$request->max_price);
        // }

        // 3. Filter Kategori
        // Logika ini sudah sesuai karena Anda menggunakan 'category' dan nilai 'all'
        if ($request->has('category') && $request->category != '' && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // 4. Sorting
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
            case 'best_seller':
                                                        // Anda perlu menambahkan kolom 'sales_count' atau sejenisnya di tabel products
                                                        // Jika tidak ada, fallback ke 'newest' atau sesuaikan
                $query->orderBy('sales_count', 'desc'); // Contoh, pastikan kolom ini ada
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sort
                break;
        }

                                          // 5. Menampilkan produk dari beberapa produk (Pagination)
        $products = $query->paginate(15); // Menampilkan 15 produk per halaman

        // Ambil daftar kategori unik untuk filter dropdown
        $categories = Product::distinct()->pluck('category')->filter()->values()->all();
        // Tambahkan opsi "Semua Kategori" di awal
        array_unshift($categories, 'all');

        // Jika request datang dari AJAX untuk tampilan mode, kita bisa return JSON
        if ($request->ajax()) {
            return response()->json([
                'products'   => $products->items(),          // Hanya item produk
                'pagination' => (string) $products->links(), // Render pagination links
            ]);
        }

        return view('view-customer.produk-customer', compact('products', 'categories'));
    }

    // Metode untuk menambah produk (dari pembahasan sebelumnya, bisa dihapus/diabaikan jika tidak dipakai)
    // public function addOneProduct()
    // {
    //     // Contoh data produk untuk testing dengan kategori
    //     $productsData = [
    //         ['name' => 'Novel Hujan', 'description' => 'Sebuah novel fiksi ilmiah romantis karya Tere Liye tentang kisah cinta di tengah hujan.', 'category' => 'Digital Content', 'price' => 75000.00, 'image_path' => 'img/novel.png'],
    //         ['name' => 'Buku Resep Masakan Nusantara', 'description' => 'Kumpulan resep masakan tradisional Indonesia dari berbagai daerah.', 'category' => 'Digital Content', 'price' => 120000.00, 'image_path' => 'https://via.placeholder.com/400x400/00FF00/000000?text=Buku+Resep'],
    //         ['name' => 'E-Book Panduan Investasi', 'description' => 'Panduan lengkap untuk pemula di dunia investasi saham dan reksadana.', 'category' => 'Digital Content', 'price' => 45000.00, 'image_path' => 'https://via.placeholder.com/400x400/0000FF/FFFFFF?text=E-Book+Investasi'],
    //         ['name' => 'Template Presentasi Powerpoint Modern', 'description' => 'Kumpulan template profesional untuk presentasi bisnis dan pendidikan.', 'category' => 'Digital Assets', 'price' => 85000.00, 'image_path' => 'https://via.placeholder.com/400x400/FFFF00/000000?text=Template+PPT'],
    //         ['name' => 'Course Desain Grafis Pemula', 'description' => 'Video tutorial interaktif untuk mempelajari dasar-dasar desain grafis.', 'category' => 'Online Courses', 'price' => 250000.00, 'image_path' => 'https://via.placeholder.com/400x400/FF00FF/FFFFFF?text=Course+Desain'],
    //         ['name' => 'Audiobook Self-Improvement', 'description' => 'Koleksi audiobook untuk pengembangan diri dan motivasi.', 'category' => 'Digital Content', 'price' => 60000.00, 'image_path' => 'https://via.placeholder.com/400x400/00FFFF/000000?text=Audiobook'],
    //         ['name' => 'Vector Icon Pack Premium', 'description' => 'Paket ikon vektor berkualitas tinggi untuk web dan aplikasi.', 'category' => 'Digital Assets', 'price' => 90000.00, 'image_path' => 'https://via.placeholder.com/400x400/C0C0C0/000000?text=Icon+Pack'],
    //         ['name' => 'Software Video Editing Portable', 'description' => 'Aplikasi editing video ringan yang bisa dijalankan tanpa instalasi.', 'category' => 'Applications', 'price' => 180000.00, 'image_path' => 'https://via.placeholder.com/400x400/808000/FFFFFF?text=Video+Software'],
    //         ['name' => 'Template Website HTML/CSS', 'description' => 'Template siap pakai untuk membuat website personal atau bisnis kecil.', 'category' => 'Digital Assets', 'price' => 110000.00, 'image_path' => 'https://via.placeholder.com/400x400/008000/FFFFFF?text=Web+Template'],
    //         ['name' => 'Preset Lightroom Pack', 'description' => 'Koleksi preset untuk editing foto profesional di Adobe Lightroom.', 'category' => 'Digital Assets', 'price' => 50000.00, 'image_path' => 'https://via.placeholder.com/400x400/000080/FFFFFF?text=Lightroom+Preset'],
    //         ['name' => 'Asset Game 2D Fantasy', 'description' => 'Kumpulan aset grafis untuk pengembangan game 2D bergenre fantasi.', 'category' => 'Digital Assets', 'price' => 200000.00, 'image_path' => 'https://via.placeholder.com/400x400/800080/FFFFFF?text=Game+Assets'],
    //         ['name' => 'Modul Belajar Coding Python', 'description' => 'Modul interaktif untuk belajar pemrograman Python dari dasar hingga mahir.', 'category' => 'Online Courses', 'price' => 150000.00, 'image_path' => 'https://via.placeholder.com/400x400/808080/FFFFFF?text=Python+Module'],
    //         ['name' => 'Font Pack Kreatif', 'description' => 'Koleksi font unik dan kreatif untuk proyek desain Anda.', 'category' => 'Digital Assets', 'price' => 30000.00, 'image_path' => 'https://via.placeholder.com/400x400/A0A0A0/000000?text=Creative+Fonts'],
    //         ['name' => 'Mockup Desain Produk 3D', 'description' => 'Mockup 3D realistis untuk presentasi desain produk Anda.', 'category' => 'Digital Assets', 'price' => 70000.00, 'image_path' => 'https://via.placeholder.com/400x400/B0B0B0/000000?text=3D+Mockup'],
    //         ['name' => 'Kumpulan Sound Effect Cinematic', 'description' => 'Efek suara berkualitas tinggi untuk produksi video dan film.', 'category' => 'Digital Assets', 'price' => 100000.00, 'image_path' => 'https://via.placeholder.com/400x400/D0D0D0/000000?text=Sound+Effects'],
    //         ['name' => 'Aplikasi Manajemen Proyek', 'description' => 'Alat untuk mengelola proyek dan tim secara efisien.', 'category' => 'Applications', 'price' => 300000.00, 'image_path' => 'https://via.placeholder.com/400x400/E0E0E0/000000?text=Project+App'],
    //         ['name' => 'Kelas Online Pemasaran Digital', 'description' => 'Pelajari strategi pemasaran digital terbaru dari ahli.', 'category' => 'Online Courses', 'price' => 400000.00, 'image_path' => 'https://via.placeholder.com/400x400/F0F0F0/000000?text=Digital+Marketing'],
    //         ['name' => 'Plugin WordPress SEO', 'description' => 'Plugin untuk meningkatkan optimasi SEO website WordPress Anda.', 'category' => 'Applications', 'price' => 120000.00, 'image_path' => 'https://via.placeholder.com/400x400/101010/FFFFFF?text=WP+SEO+Plugin'],
    //         ['name' => 'Buku Audio Sejarah Dunia', 'description' => 'Dengarkan perjalanan sejarah dunia dalam format audio.', 'category' => 'Digital Content', 'price' => 95000.00, 'image_path' => 'https://via.placeholder.com/400x400/202020/FFFFFF?text=History+Audiobook'],
    //         ['name' => 'Software Akuntansi Cloud', 'description' => 'Solusi akuntansi berbasis cloud untuk bisnis kecil dan menengah.', 'category' => 'Applications', 'price' => 280000.00, 'image_path' => 'https://via.placeholder.com/400x400/303030/FFFFFF?text=Cloud+Accounting'],
    //     ];

    //     foreach ($productsData as $data) {
    //         Product::create($data);
    //     }

    //     return "Produk '" . count($productsData) . "' berhasil ditambahkan untuk testing!";
    // }

    
}
