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
}
