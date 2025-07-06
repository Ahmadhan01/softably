<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SoftPayTransaction;
use App\Models\Product; // Pastikan ini diimpor
use App\Models\SellerNotification; // Pastikan ini diimpor
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class SoftPayController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $softpayBalance = $user->softpay_balance ?? 0;

        $recentTransactions = SoftPayTransaction::where('user_id', $user->id)
                                                ->orderBy('created_at', 'desc')
                                                ->take(4)
                                                ->get()
                                                ->map(function ($transaction) {
                                                    return [
                                                        'type' => ucfirst($transaction->type),
                                                        'description' => $transaction->description,
                                                        'date' => $transaction->created_at->diffForHumans(),
                                                        'amount' => $transaction->amount,
                                                    ];
                                                });
        return view('view-customer.softpay-customer', compact('softpayBalance', 'recentTransactions'));
    }

    // Metode contoh untuk memproses pembayaran produk menggunakan SoftPay
    // Anda mungkin sudah memiliki metode ini di CheckoutController atau tempat lain.
    // Pastikan untuk mengadaptasi logika ini ke metode yang relevan di aplikasi Anda.
    public function processProductPayment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // ... validasi lain yang mungkin dibutuhkan untuk checkout
        ]);

        $customer = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $totalAmount = $product->price * $quantity;
        $seller = $product->user; // Asumsi relasi product->user adalah seller

        // Validasi ketersediaan saldo customer
        if (($customer->softpay_balance ?? 0) < $totalAmount) {
            return back()->with('error', 'Saldo SoftPay tidak mencukupi untuk pembelian ini.');
        }

        // Mulai transaksi database untuk atomicity
        DB::beginTransaction();
        try {
            // 1. Kurangi saldo SoftPay customer
            $customer->softpay_balance -= $totalAmount;
            $customer->save();

            // 2. Tambah saldo SoftPay seller
            $seller->softpay_balance += $totalAmount;
            $seller->save();

            // 3. Catat transaksi untuk customer (pengurangan)
            SoftPayTransaction::create([
                'user_id' => $customer->id,
                'type' => 'Pembelian Produk',
                'amount' => -$totalAmount, // Negatif karena pengeluaran
                'description' => "Pembelian produk '{$product->name}' (qty: {$quantity}) dari {$seller->name}",
                'status' => 'completed',
                'reference_id' => 'BUY-' . uniqid(),
            ]);

            // 4. Catat transaksi untuk seller (pemasukan)
            SoftPayTransaction::create([
                'user_id' => $seller->id, // User ID seller
                'type' => 'Pemasukan Penjualan',
                'amount' => $totalAmount, // Positif karena pemasukan
                'description' => "Pemasukan dari penjualan produk '{$product->name}' (qty: {$quantity}) ke {$customer->name}",
                'status' => 'completed',
                'reference_id' => 'SALE-' . uniqid(),
            ]);

            // 5. Kirim notifikasi ke seller
            SellerNotification::create([
                'seller_id' => $seller->id,
                'type' => 'softpay_income',
                'title' => 'Pemasukan SoftPay Baru!',
                'message' => "Anda menerima Rp " . number_format($totalAmount, 0, ',', '.') . " dari penjualan produk '{$product->name}' kepada {$customer->name}.",
                'is_read' => false,
            ]);

            // TODO: Tambahkan logika lain yang relevan dengan transaksi pembelian
            // Misalnya: membuat entri di tabel 'orders' atau 'transaction_details',
            // mengurangi stok produk, dll.

            DB::commit();

            return back()->with('success', 'Pembelian berhasil menggunakan SoftPay! Saldo SoftPay Anda telah berkurang dan saldo penjual telah bertambah.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    // Metode topup, withdraw, pay, transfer, history, promo, help bisa ditambahkan di sini
    // ... (sesuaikan dengan SoftPayController Anda yang sudah ada)

    public function showTopUpForm() { return view('view-customer.softpay.topup'); }
    public function showWithdrawForm() { return view('view-customer.softpay.withdraw'); }
    public function showPayForm() { return view('view-customer.softpay.pay'); }
    public function showTransferForm() { return view('view-customer.softpay.transfer'); }
    public function history() {
        $user = Auth::user();
        $transactions = SoftPayTransaction::where('user_id', $user->id)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10);
        $transactions->getCollection()->transform(function ($transaction) {
            return [
                'type' => ucfirst($transaction->type),
                'description' => $transaction->description ?: 'Transaksi SoftPay',
                'date' => $transaction->created_at->format('d M Y, H:i'),
                'amount' => $transaction->amount,
                'status' => ucfirst($transaction->status),
            ];
        });
        return view('view-customer.softpay.history', compact('transactions'));
    }
    public function promo() { return view('view-customer.softpay.promo'); }
    public function help() { return view('view-customer.softpay.help'); }

    // Contoh untuk processTopUp (jika belum ada)
    public function processTopUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        DB::beginTransaction();
        try {
            $user->softpay_balance += $amount;
            $user->save();

            SoftPayTransaction::create([
                'user_id' => $user->id,
                'type' => 'Isi Saldo',
                'amount' => $amount,
                'description' => 'Top-up saldo SoftPay.',
                'status' => 'completed',
                'reference_id' => 'TOPUP-' . uniqid(),
            ]);

            DB::commit();
            return redirect()->route('softpay.index')->with('success', 'Isi Saldo berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat isi saldo: ' . $e->getMessage());
        }
    }

    // Contoh untuk processWithdraw (jika belum ada, ini adalah sisi customer)
    public function processWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:' . (Auth::user()->softpay_balance ?? 0),
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        if (($user->softpay_balance ?? 0) < $amount) {
            return back()->withErrors(['amount' => 'Saldo SoftPay tidak mencukupi.']);
        }

        DB::beginTransaction();
        try {
            $user->softpay_balance -= $amount;
            $user->save();

            SoftPayTransaction::create([
                'user_id' => $user->id,
                'type' => 'Tarik Saldo',
                'amount' => -$amount,
                'description' => 'Penarikan saldo SoftPay.',
                'status' => 'completed', // Asumsi langsung complete jika langsung kurangi saldo
                'reference_id' => 'WDCUS-' . uniqid(),
            ]);

            DB::commit();
            return redirect()->route('softpay.index')->with('success', 'Penarikan saldo berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat penarikan saldo: ' . $e->getMessage());
        }
    }
}