<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            Log::info('CartController@index - User not authenticated, redirecting to login.');
            return redirect()->route('login');
        }   

        $query = $user->carts()->with('product.user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $cartItems = $query->latest()->get();

        $selectedCartItemIds = session('selected_cart_items_for_checkout', []);
        Log::debug('CartController@index - Session selected_cart_items_for_checkout:', $selectedCartItemIds);

        return view('view-customer.cart-customer', compact('cartItems', 'selectedCartItemIds'));
    }

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

    public function destroy(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang.', 'cartCount' => Auth::user()->carts()->count()]);
    }

    public function destroyMultiple(Request $request)
    {
        Log::info('DestroyMultiple request received:', $request->all());

        $request->validate([
            'cart_item_ids' => 'required|array',
            'cart_item_ids.*' => 'exists:carts,id',
        ]);

        $deletedCount = Cart::whereIn('id', $request->cart_item_ids)
                            ->where('user_id', Auth::id())
                            ->delete();

        Log::info('Deleted count for user ' . Auth::id() . ':', ['ids' => $request->cart_item_ids, 'count' => $deletedCount]);

        if ($deletedCount > 0) {
            return response()->json([
                'message' => $deletedCount . ' produk berhasil dihapus dari keranjang.',
                'cartCount' => Auth::user()->carts()->count()
            ]);
        } else {
            return response()->json([
                'message' => 'Tidak ada produk yang dihapus (mungkin sudah dihapus atau tidak valid).',
                'cartCount' => Auth::user()->carts()->count()
            ], 200);
        }
    }

    /**
     * Metode ini akan dipanggil dari halaman keranjang untuk MENGAMBIL ID ITEM YANG DIPILIH
     * dan menyimpannya ke sesi, lalu redirect ke halaman checkout.
     * Nama metode ini lebih tepat: prepareCheckout.
     */
    public function processToCheckout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array', // Validasi untuk nama input yang benar dari frontend
            'selected_items.*' => 'exists:carts,id',
        ]);

        $selectedCartItemIds = $request->input('selected_items');
        Log::debug('CartController@processToCheckout - Selected items received:', $selectedCartItemIds);

        // Simpan ID item keranjang yang dipilih ke dalam sesi
        $request->session()->put('selected_cart_items_for_checkout', $selectedCartItemIds);
        Log::debug('CartController@processToCheckout - Stored in session:', session('selected_cart_items_for_checkout'));

        // Redirect ke halaman checkout
        return redirect()->route('checkout-customer.index');
    }

    // Hapus atau komentari metode ini karena fungsinya ada di CheckoutController@processCheckout
    // public function processCheckout(Request $request)
    // {
    //     // ... logika yang tumpang tindih ...
    //     return redirect()->route('checkout-customer.index');
    // }
}