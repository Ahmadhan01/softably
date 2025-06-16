<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Menampilkan daftar wishlist user (opsional, jika ada halaman wishlist_customer)
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->get();
        return view('view-customer.wishlist-customer', compact('wishlists'));
    }

    // Menambah produk ke wishlist
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

    // Menghapus produk dari wishlist (jika ada halaman wishlist terpisah)
    public function destroy(Wishlist $wishlist)
    {
        // Pastikan user adalah pemilik wishlist item ini
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak berhak menghapus item wishlist ini.'], 403);
        }

        $wishlist->delete();
        return response()->json(['success' => true, 'message' => 'Produk dihapus dari wishlist.']);
    }
}