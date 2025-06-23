<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product; // Pastikan ini diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk debugging
use Illuminate\Database\Eloquent\Relations\HasMany;

class WishlistController extends Controller
{
    /**
     * Menampilkan semua item di wishlist pengguna yang sedang login.
     * Mengimplementasikan filter (opsional), sorting, dan pencarian.
     */
    public function index(Request $request)
    {
        $user = Auth::user();   
        if (!$user) {
            return redirect()->route('login');
        }

        dd($user);
        $query = $user->wishlists()->with('product', 'product.seller');

        // --- Implementasi Pencarian (Search) ---
        $searchQuery = $request->input('search', '');
        if ($searchQuery) {
            $query->whereHas('product', function ($q) use ($searchQuery) {
                $q->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // --- Implementasi Sorting ---
        $sortBy = $request->input('sort_by', 'newest'); // Default 'newest'

        switch ($sortBy) {
            case 'newest':
                $query->latest(); // Mengurutkan berdasarkan 'created_at' DESC dari wishlist item
                break;
            case 'oldest':
                $query->oldest(); // Mengurutkan berdasarkan 'created_at' ASC dari wishlist item
                break;
            case 'price_asc':
                $query->whereHas('product', function ($q) {
                    $q->orderBy('price', 'asc');
                });
                break;
            case 'price_desc':
                $query->whereHas('product', function ($q) {
                    $q->orderBy('price', 'desc');
                });
                break;
            // Anda bisa menambahkan 'best_seller' di sini jika product memiliki sales_count
            // case 'best_seller':
            //     $query->whereHas('product', function ($q) {
            //         $q->orderBy('sales_count', 'desc');
            //     });
            //     break;
        }

        // --- Implementasi Filter by Purchased (Opsional dan lebih kompleks) ---
        // Ini memerlukan relasi atau logic tambahan untuk memeriksa apakah produk di wishlist
        // juga telah dibeli oleh user. Jika Anda ingin ini berfungsi, Anda perlu:
        // 1. Memastikan model User memiliki relasi ke transaksi/detail transaksi
        // 2. Menyesuaikan query di sini.
        // Untuk saat ini, kita akan mengabaikannya agar Anda bisa fokus pada fitur dasar.
        // $filterBy = $request->input('filter_by', 'all');
        // if ($filterBy == 'purchased') {
        //     // Example: requires User->purchasedProducts() relation
        //     $purchasedProductIds = $user->purchasedProducts->pluck('product_id')->unique();
        //     $query->whereIn('product_id', $purchasedProductIds);
        // }


        $wishlistItems = $query->paginate(10); // Paginate hasilnya, 10 item per halaman

        return view('view-customer.wishlist-customer', [
            'wishlistItems' => $wishlistItems,
            'searchQuery' => $searchQuery,
            'sortBy' => $sortBy,
            // 'filterBy' => $filterBy, // Jika filter 'purchased' diaktifkan
        ]);
    }

    /**
     * Menambah atau menghapus produk dari wishlist (toggle functionality).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk menambah ke wishlist.'], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        // Cek apakah produk sudah ada di wishlist
        $existingWishlist = Wishlist::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();

        if ($existingWishlist) {
            // Jika sudah ada, hapus dari wishlist (toggle functionality)
            $existingWishlist->delete();
            return response()->json(['success' => true, 'action' => 'removed', 'message' => 'Produk dihapus dari wishlist.']);
        } else {
            // Jika belum ada, tambahkan ke wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return response()->json(['success' => true, 'action' => 'added', 'message' => 'Produk ditambahkan ke wishlist.']);
        }
    }

    /**
     * Menghapus produk dari wishlist (jika ada halaman wishlist terpisah dan tombol hapus individu).
     * Metode ini akan dipanggil jika frontend mengirimkan DELETE request ke /wishlist/{product}
     * Atau bisa juga dihapus jika store() menangani semua toggle.
     */
    public function destroy(Product $product) // Menggunakan Route Model Binding
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus dari wishlist.']);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di wishlist Anda.'], 404);
    }
}