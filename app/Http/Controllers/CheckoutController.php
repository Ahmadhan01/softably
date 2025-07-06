<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Notification;
use App\Http\Controllers\SellerNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\SoftPayTransaction;
use App\Models\User;    

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout dengan item dari keranjang user yang sedang login.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $selectedCartItemIds = session('selected_cart_items_for_checkout', []);

        if (empty($selectedCartItemIds) && !session()->has('success_modal_data')) {
             return redirect()->route('cart-customer.index')->with('error', 'Pilih setidaknya satu produk dari keranjang untuk checkout.');
        }

        $checkoutItems = $user->carts()->with('product')
                             ->whereIn('id', $selectedCartItemIds)
                             ->get();

        $subtotal = $checkoutItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $discount = 0;
        // Convenience fee awal yang akan dihitung ulang di frontend berdasarkan pilihan metode
        // Di sini kita bisa set default atau 0, karena frontend yang akan menghitungnya pertama kali
        $initialConvenienceFee = 0; // Set initial ke 0 atau nilai default yang paling rendah
        $initialTotalAmount = $subtotal - $discount + $initialConvenienceFee;

        $softpayBalance = $user->softpay_balance;

        $buyerInfo = [
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone_number,
        ];

        // Definisi biaya untuk masing-masing metode pembayaran
        $qrisFee = 5000;
        $bankTransferFee = 10000;
        // SoftPay fee is implicitly 0, so no need to pass a variable for it unless you want to be explicit

        // Metode pembayaran yang akan ditampilkan di frontend
        // Tidak perlu dilewatkan sebagai array terpisah jika kita hardcode di blade
        // Tapi jika ingin dinamis, biarkan seperti ini dan sesuaikan blade
        // $paymentMethods = [
        //     'QRIS',
        //     'Bank Transfer', // Digabung menjadi satu
        // ];

        return view('view-customer.checkout-customer', compact(
            'checkoutItems',
            'buyerInfo',
            'subtotal',
            'discount',
            'initialConvenienceFee', // Mengganti convenienceFee
            'initialTotalAmount',    // Mengganti totalAmount
            // 'paymentMethods', // Jika Anda hardcode di blade, ini tidak perlu
            'softpayBalance',
            'qrisFee',               // Kirim biaya ke blade
            'bankTransferFee'        // Kirim biaya ke blade
        ));
    }

    /**
     * Memproses pembelian akhir dari halaman checkout (untuk QRIS dan Bank Transfer).
     */
    public function processCheckout(Request $request)
    {
        Log::debug('CheckoutController@processCheckout - Request received:', $request->all());

        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|string|in:QRIS,Bank Transfer', // Validasi metode pembayaran yang diizinkan
            'agree_terms' => 'accepted',
            'selected_cart_items' => 'required|array',
            'selected_cart_items.*' => 'exists:carts,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            Log::warning('CheckoutController@processCheckout - Unauthorized user access.');
            return redirect()->route('login');
        }

        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');
        $user->save();
        Log::debug('User info updated:', ['user_id' => $user->id, 'email' => $user->email]);

        $cartItemsToProcess = $user->carts()->with('product')
                                      ->whereIn('id', $request->input('selected_cart_items'))
                                      ->get();

        if ($cartItemsToProcess->isEmpty()) {
            Log::warning('CheckoutController@processCheckout - No valid products found to process after validation.', ['selected_ids_from_request' => $request->input('selected_cart_items'), 'user_id' => $user->id]);
            return redirect()->route('cart-customer.index')->with('error', 'Tidak ada produk valid untuk diproses.');
        }

        foreach ($cartItemsToProcess as $item) {
            if (empty($item->product->image_path)) {
                Log::error('CheckoutController@processCheckout - Product missing image:', ['product_id' => $item->product->id, 'product_name' => $item->product->name]);
                return redirect()->route('checkout-customer.index')->with('error', 'Produk "' . $item->product->name . '" tidak memiliki gambar. Harap hubungi dukungan.');
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItemsToProcess->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
            $discount = 0;
            $convenienceFee = 0; // Default

            $paymentMethod = $request->input('payment_method');
            if ($paymentMethod === 'QRIS') {
                $convenienceFee = 5000;
            } elseif ($paymentMethod === 'Bank Transfer') {
                $convenienceFee = 10000;
            }
            // SoftPay ditangani di metode processSoftPayPayment

            $totalAmount = $subtotal - $discount + $convenienceFee;

            $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . time();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'convenience_fee' => $convenienceFee,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'status' => 'pending', // Status 'pending' untuk pembayaran eksternal (QRIS, Bank Transfer)
            ]);
            Log::debug('Transaction created:', ['transaction_id' => $transaction->id, 'invoice' => $invoiceNumber]);

            foreach ($cartItemsToProcess as $item) {
                $transactionDetail = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'product_image_path' => $item->product->image_path,
                    'price' => $item->product->price,
                    'price_per_unit' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
                SellerNotificationController::createTransactionNotification($transactionDetail);
            }

            Cart::whereIn('id', $request->input('selected_cart_items'))
                ->where('user_id', $user->id)
                ->delete();
            Log::debug('Cart items deleted:', ['deleted_ids' => $request->input('selected_cart_items')]);

            DB::commit();
            Log::debug('Database transaction committed successfully.');

            $productNames = $cartItemsToProcess->map(function($item) {
                return $item->product->name;
            })->implode(', ');

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pembelian Berhasil!',
                'message' => 'Pesanan Anda untuk produk ' . $productNames . ' dengan nomor invoice ' . $invoiceNumber . ' telah berhasil diproses. Menunggu pembayaran via ' . $paymentMethod . '.',
                'type' => 'transaction',
                'is_read' => false,
                'data' => json_encode(['invoice_number' => $invoiceNumber, 'total_amount' => $totalAmount, 'status' => 'pending']),
            ]);

            $successModalData = [
                'invoice_id' => $transaction->id,
                'invoice_number' => $invoiceNumber,
                'email' => $user->email,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'discount' => number_format($discount, 0, ',', '.'),
                'convenience_fee' => number_format($convenienceFee, 0, ',', '.'),
                'total_amount' => number_format($totalAmount, 0, ',', '.'),
                'payment_method' => $paymentMethod,
                'products' => $cartItemsToProcess->map(function($item) {
                    return [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => number_format($item->product->price, 0, ',', '.'),
                        'image_url' => $item->product->image_url,
                    ];
                })->toArray(),
            ];

            return redirect()->back()->with('success', 'Pembelian berhasil! Order Anda sedang menunggu pembayaran.')
                             ->with('success_modal_data', $successModalData);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed (exception caught): ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile());
            return redirect()->route('checkout-customer.index')->with('error', 'Terjadi kesalahan saat memproses checkout: ' . $e->getMessage() . '. Silakan coba lagi.');
        }
    }

    public function processSoftPayPayment(Request $request)
    {
        $user = Auth::user();

        $selectedCartItemIds = $request->session()->get('selected_cart_items_for_checkout', []);
        $cartItemsToProcess = Cart::where('user_id', $user->id)
                                    ->whereIn('id', $selectedCartItemIds)
                                    ->with('product')
                                    ->get();

        if ($cartItemsToProcess->isEmpty()) {
            return redirect()->route('cart-customer.index')->with('error', 'Tidak ada produk valid untuk diproses dengan SoftPay.');
        }

        $subtotal = $cartItemsToProcess->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        $convenienceFee = 0; // SoftPay fee is 0
        $totalAmount = $subtotal + $convenienceFee;

        if ($user->softpay_balance < $totalAmount) {
            return redirect()->back()->with('error', 'Saldo SoftPay tidak mencukupi untuk pembayaran ini.');
        }

        try {
            DB::beginTransaction();

            // Generate invoice number early
            $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . time();
            Log::debug('Generated Invoice Number: ' . $invoiceNumber);

            // Buat Transaksi Utama (Order) terlebih dahulu untuk mendapatkan ID transaksi
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber, // Gunakan invoiceNumber yang sudah dibuat
                'subtotal' => $subtotal,
                'discount' => 0,
                'convenience_fee' => $convenienceFee,
                'total_amount' => $totalAmount,
                'payment_method' => 'SoftPay',
                'status' => 'completed',
            ]);
            Log::debug('Main transaction created:', ['transaction_id' => $transaction->id, 'invoice' => $invoiceNumber]);

            // Kurangi Saldo SoftPay customer
            $user->softpay_balance -= $totalAmount;
            $user->save();
            Log::debug('SoftPay balance reduced:', ['user_id' => $user->id, 'new_balance' => $user->softpay_balance]);

            // Catat Transaksi SoftPay (Pengeluaran) customer
            SoftPayTransaction::create([
                'user_id' => $user->id,
                'type' => 'Pembelian Produk',
                'amount' => -$totalAmount,
                'description' => 'Pembayaran produk (Invoice: ' . $invoiceNumber . ')',
                'status' => 'completed',
                'transaction_id' => $transaction->id,
            ]);
            Log::debug('SoftPay transaction (customer) created:', ['transaction_id' => $transaction->id]);


            // Buat Detail Transaksi, Tambah Saldo Seller, Catat Transaksi Seller, dan Hapus Item dari Keranjang
            foreach ($cartItemsToProcess as $item) {
                // Hitung subtotal item untuk penggunaan di sini
                $itemSubtotalCalculated = $item->quantity * $item->product->price;

                $transactionDetail = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'product_image_path' => $item->product->image_path,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'price_per_unit' => $item->product->price,
                    'subtotal' => $itemSubtotalCalculated, // Gunakan yang dihitung
                ]);
                $product = Product::find($item->product->id); // Ambil objek produk lengkap lagi
                if ($product) {
                    $product->increment('sales_count', $item->quantity);
                    Log::debug("Product sales_count incremented for product_id: {$product->id}, quantity: {$item->quantity}");

                    // --- DEBUG LOG UNTUK SUBTOTA L---
                    // Hapus baris ini setelah perbaikan. Ini untuk memastikan nilai ada.
                    Log::debug("DEBUG: item->quantity: {$item->quantity}, item->product->price: {$item->product->price}, itemSubtotalCalculated: {$itemSubtotalCalculated}");

                    $seller = $product->user; // Dapatkan user (seller) pemilik produk
                    if ($seller && $seller->isSeller()) {
                        $seller->softpay_balance += $itemSubtotalCalculated; // <-- UBAH KE SINI
                        $seller->save();
                        Log::debug("Seller SoftPay balance updated: user_id={$seller->id}, new_balance={$seller->softpay_balance}");

                        SoftPayTransaction::create([
                            'user_id' => $seller->id,
                            'type' => 'Pemasukan Penjualan',
                            'amount' => $itemSubtotalCalculated, // <-- UBAH KE SINI
                            'description' => "Pemasukan dari penjualan produk '{$item->product->name}' (Invoice: {$invoiceNumber})",
                            'status' => 'completed',
                            'transaction_id' => $transaction->id,
                        ]);
                        Log::debug("SoftPay transaction for seller created: user_id={$seller->id}, amount={$itemSubtotalCalculated}");
                    } else {
                        Log::warning("SoftPay Issue: Seller not found or not a seller for product ID {$product->id}. Product user_id: {($product->user_id ?? 'N/A')}.");
                    }
                }

                SellerNotificationController::createTransactionNotification($transactionDetail);
            }
            Log::debug('Transaction details created and seller notifications triggered.');

            Cart::whereIn('id', $selectedCartItemIds)
                ->where('user_id', $user->id)
                ->delete();
            Log::debug('Cart items deleted after SoftPay purchase:', ['deleted_ids' => $selectedCartItemIds]);

            // Kirim Notifikasi Keberhasilan kepada pembeli
            $productNames = $cartItemsToProcess->map(function($item) {
                return $item->product->name;
            })->implode(', ');

            Notification::create([
                'user_id' => $user->id,
                'type' => 'transaction',
                'title' => 'Pembayaran SoftPay Berhasil!',
                'message' => 'Pembayaran Anda untuk produk ' . $productNames . ' dengan nomor invoice ' . $invoiceNumber . ' telah berhasil diproses menggunakan SoftPay.',
                'is_read' => false,
                'data' => json_encode(['invoice_number' => $invoiceNumber, 'total_amount' => $totalAmount]),
            ]);
            Log::debug('Buyer notification created for SoftPay purchase:', ['user_id' => $user->id, 'invoice_number' => $invoiceNumber]);


            DB::commit();
            Log::debug('SoftPay transaction committed successfully.');

            $successModalData = [
                'invoice_id' => $transaction->id,
                'invoice_number' => $invoiceNumber,
                'email' => $user->email,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'discount' => number_format(0, 0, ',', '.'),
                'convenience_fee' => number_format($convenienceFee, 0, ',', '.'),
                'total_amount' => number_format($totalAmount, 0, ',', '.'),
                'payment_method' => 'SoftPay',
                'products' => $cartItemsToProcess->map(function($item) {
                    return [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => number_format($item->product->price, 0, ',', '.'),
                    'image_url' => $item->product->image_url,
                    
                    ];
                })->toArray(),
            ];

            $request->session()->forget('selected_cart_items_for_checkout');
            Log::debug('Session selected_cart_items_for_checkout cleared after SoftPay purchase.');


            return redirect()->route('checkout-customer.index')->with('success', 'Pembayaran SoftPay berhasil dan pesanan Anda telah dibuat!')
                             ->with('success_modal_data', $successModalData);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SoftPay checkout failed (exception caught): ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile());

            Notification::create([
                'user_id' => $user->id,
                'type' => 'transaction',
                'title' => 'Pembayaran SoftPay Gagal!',
                'message' => 'Terjadi kesalahan saat memproses pembayaran SoftPay Anda: ' . $e->getMessage() . '. Saldo tidak terpotong. Silakan coba lagi atau hubungi dukungan.',
                'is_read' => false,
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran SoftPay: ' . $e->getMessage());
        }
    }
}