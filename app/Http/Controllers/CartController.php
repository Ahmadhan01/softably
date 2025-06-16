<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan daftar cart user (opsional, jika ada halaman cart_customer)
    public function index()
    {
        $carts = Auth::user()->carts()->with('product')->get();
        return view('view-customer.cart-customer', compact('carts'));
    }

    // Menambah produk ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1', // Kuantitas opsional, default 1
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk menambah ke keranjang.'], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $existingCartItem = Cart::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingCartItem) {
            // Jika produk sudah ada di keranjang, update kuantitasnya
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
            return response()->json(['success' => true, 'action' => 'updated', 'message' => 'Kuantitas produk di keranjang diperbarui.']);
        } else {
            // Jika belum ada, tambahkan sebagai item baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
            return response()->json(['success' => true, 'action' => 'added', 'message' => 'Produk ditambahkan ke keranjang.']);
        }
    }

    // Mengupdate kuantitas item di keranjang
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak berhak mengupdate item keranjang ini.'], 403);
        }

        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json(['success' => true, 'message' => 'Kuantitas keranjang berhasil diperbarui.']);
    }

    // Menghapus item dari keranjang
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak berhak menghapus item keranjang ini.'], 403);
        }

        $cart->delete();
        return response()->json(['success' => true, 'message' => 'Produk dihapus dari keranjang.']);
    }
}