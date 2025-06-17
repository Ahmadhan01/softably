<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk debugging

class CartController extends Controller
{
    /**
     * Menampilkan semua item di keranjang pengguna yang sedang login.
     * Menerapkan fitur pencarian.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $query = $user->carts()->with('product');

        // Logika pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $cartItems = $query->latest()->get();

        return view('view-customer.cart-customer', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang atau memperbarui kuantitasnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $product_id = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
            $message = 'Kuantitas produk di keranjang berhasil diperbarui!';
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        return response()->json(['message' => $message, 'cartCount' => $user->carts()->count()]);
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Kuantitas berhasil diperbarui.', 'newTotal' => $cart->quantity * $cart->product->price]);
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang.', 'cartCount' => Auth::user()->carts()->count()]);
    }

    /**
     * Menghapus banyak item dari keranjang (fitur baru untuk tombol 'Delete').
     */
    public function destroyMultiple(Request $request)
    {
        Log::info('DestroyMultiple request received:', $request->all()); // Log masuk
        
        $request->validate([
            'cart_item_ids' => 'required|array',
            'cart_item_ids.*' => 'exists:carts,id',
        ]);

        $deletedCount = Cart::whereIn('id', $request->cart_item_ids)
                            ->where('user_id', Auth::id())
                            ->delete();

        Log::info('Deleted count for user ' . Auth::id() . ':', ['ids' => $request->cart_item_ids, 'count' => $deletedCount]); // Log hasil

        if ($deletedCount > 0) {
            return response()->json([
                'message' => $deletedCount . ' produk berhasil dihapus dari keranjang.',
                'cartCount' => Auth::user()->carts()->count()
            ]);
        } else {
            // Mengembalikan status 200 OK karena permintaan diproses, hanya tidak ada item yang match.
            return response()->json([
                'message' => 'Tidak ada produk yang dihapus (mungkin sudah dihapus atau tidak valid).',
                'cartCount' => Auth::user()->carts()->count()
            ], 200); 
        }
    }
}