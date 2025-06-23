<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Pastikan ini sudah ada

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout dengan item dari keranjang user yang sedang login.
     * HARUSNYA INI HANYA MENAMPILKAN ITEM YANG DIPILIH DARI HALAMAN KERANJANG.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $selectedCartItemIds = session('selected_cart_items_for_checkout', []);

        // Log::debug('CheckoutController@index - Selected Cart Item IDs from session:', $selectedCartItemIds); // Debugging

        if (empty($selectedCartItemIds) && !session()->has('success_modal_data')) { //
             return redirect()->route('cart-customer.index')->with('error', 'Pilih setidaknya satu produk dari keranjang untuk checkout.');
        }

        $checkoutItems = $user->carts()->with('product')
                             ->whereIn('id', $selectedCartItemIds)
                             ->get();

        // if ($checkoutItems->isEmpty()) {
        //     Log::warning('CheckoutController@index - No valid products found for checkout based on session IDs.', ['selected_ids' => $selectedCartItemIds, 'user_id' => $user->id]); // Debugging
        //     session()->forget('selected_cart_items_for_checkout'); // Hapus session jika tidak ada item valid
        //     return redirect()->route('cart-customer.index')->with('error', 'Tidak ada produk valid yang dipilih untuk checkout.');
        // }

        $subtotal = $checkoutItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $discount = 0;
        $convenienceFee = 15000;

        $totalAmount = $subtotal - $discount + $convenienceFee;

        $buyerInfo = [
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone_number,
        ];

        $paymentMethods = [
            'QRIS',
            'Bank Transfer (BCA)',
            'Bank Transfer (Mandiri)',
            'Credit Card',
            'OVO',
            'Gopay',
        ];

        return view('view-customer.checkout-customer', compact('checkoutItems', 'buyerInfo', 'subtotal', 'discount', 'convenienceFee', 'totalAmount', 'paymentMethods'));
    }

    /**
     * Memproses pembelian akhir dari halaman checkout.
     */
    public function processCheckout(Request $request)
    {
        Log::debug('CheckoutController@processCheckout - Request received:', $request->all()); // Debugging Awal

        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|string',
            'agree_terms' => 'accepted',
            'selected_cart_items' => 'required|array',
            'selected_cart_items.*' => 'exists:carts,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            Log::warning('CheckoutController@processCheckout - Unauthorized user access.'); // Debugging
            return redirect()->route('login');
        }

        // --- Perbarui informasi user jika ada perubahan dari form ---
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');
        $user->save();
        Log::debug('User info updated:', ['user_id' => $user->id, 'email' => $user->email]); // Debugging
        // -----------------------------------------------------------

        // AMBIL ITEM HANYA YANG DIPILIH DARI FORM CHECKOUT
        $cartItemsToProcess = $user->carts()->with('product')
                                      ->whereIn('id', $request->input('selected_cart_items'))
                                      ->get();

        if ($cartItemsToProcess->isEmpty()) {
            Log::warning('CheckoutController@processCheckout - No valid products found to process after validation.', ['selected_ids_from_request' => $request->input('selected_cart_items'), 'user_id' => $user->id]); // Debugging
            return redirect()->route('cart-customer.index')->with('error', 'Tidak ada produk valid untuk diproses.');
        }

        // Periksa apakah semua produk memiliki gambar
        foreach ($cartItemsToProcess as $item) {
            if (empty($item->product->image_path)) { // Asumsi 'image' adalah nama kolom di tabel produk
                Log::error('CheckoutController@processCheckout - Product missing image:', ['product_id' => $item->product->id, 'product_name' => $item->product->name]);
                DB::rollBack(); // Penting: rollback jika terjadi kesalahan sebelum commit
                return redirect()->route('checkout-customer.index')->with('error', 'Produk "' . $item->product->name . '" tidak memiliki gambar. Harap hubungi dukungan.');
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItemsToProcess->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
            $discount = 0;
            $convenienceFee = 15000;
            $totalAmount = $subtotal - $discount + $convenienceFee;

            $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . time();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'convenience_fee' => $convenienceFee,
                'total_amount' => $totalAmount,
                'payment_method' => $request->input('payment_method'),
                'status' => 'completed', // Status awal 'completed' atau 'pending' tergantung alur pembayaran Anda
            ]);
            Log::debug('Transaction created:', ['transaction_id' => $transaction->id, 'invoice' => $invoiceNumber]); // Debugging

            foreach ($cartItemsToProcess as $item) { // Loop hanya item yang dipilih
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'product_image' => $item->product->image_path, // Simpan path gambar produk
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }
            Log::debug('Transaction details created for:', ['count' => $cartItemsToProcess->count()]); // Debugging

            // Hapus hanya item yang diproses dari keranjang
            Cart::whereIn('id', $request->input('selected_cart_items'))
                ->where('user_id', $user->id)
                ->delete();
            Log::debug('Cart items deleted:', ['deleted_ids' => $request->input('selected_cart_items')]); // Debugging

            DB::commit();
            Log::debug('Database transaction committed successfully.'); // Debugging

            $productNames = $cartItemsToProcess->map(function($item) {
                return $item->product->name;
            })->implode(', ');

            Notification::create([ // Ini akan membuat notifikasi di database
                'user_id' => $user->id,
                'title' => 'Pembelian Berhasil!',
                'message' => 'Pesanan Anda untuk produk ' . $productNames . ' dengan nomor invoice ' . $invoiceNumber . ' telah berhasil diproses.',
                'type' => 'transaction',
                'is_read' => false,
                'data' => json_encode(['invoice_number' => $invoiceNumber, 'total_amount' => $totalAmount]),
            ]);
            Log::debug('Notification created for user:', ['user_id' => $user->id, 'invoice_number' => $invoiceNumber]);

            // Hapus session 'selected_cart_items_for_checkout' setelah berhasil checkout
            // $request->session()->forget('selected_cart_items_for_checkout');
            // Log::debug('Session selected_cart_items_for_checkout cleared.'); // Debugging

            // Siapkan data untuk modal sukses
            $successModalData = [
                'invoice_number' => $invoiceNumber,
                'email' => $user->email,
                'subtotal' => number_format($subtotal, 0, ',', '.'), // Format untuk tampilan modal
                'discount' => number_format($discount, 0, ',', '.'),
                'convenience_fee' => number_format($convenienceFee, 0, ',', '.'),
                'total_amount' => number_format($totalAmount, 0, ',', '.'),
                'payment_method' => $request->input('payment_method'),
                'products' => $cartItemsToProcess->map(function($item) {
                    return [
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => number_format($item->product->price, 0, ',', '.'),
                        'image' => $item->product->image_path, // Menggunakan accessor image_path
                    ];
                })->toArray(),
            ];

            // Redirect ke halaman order dengan pesan sukses dan data modal di session
            return redirect()->back()->with('success', 'Pembelian berhasil! Order Anda telah disimpan.')
                             ->with('success_modal_data', $successModalData);   

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed (exception caught): ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile());
            // Berikan pesan error yang lebih informatif di sini jika memungkinkan
            return redirect()->route('checkout-customer.index')->with('error', 'Terjadi kesalahan saat memproses checkout: ' . $e->getMessage() . '. Silakan coba lagi.');
        }
    }
}