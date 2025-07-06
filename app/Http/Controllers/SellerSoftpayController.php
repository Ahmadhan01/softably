<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Mengacu pada model User untuk saldo SoftPay
use App\Models\SoftPayTransaction; // Untuk riwayat transaksi SoftPay
use App\Models\Product; // Digunakan untuk mencari produk dan pemiliknya (seller)
use App\Models\TransactionDetail; // Digunakan untuk mendapatkan detail transaksi pembelian

class SellerSoftpayController extends Controller
{
    /**
     * Menampilkan dashboard SoftPay untuk penjual.
     */
    public function index()
    {
        $seller = Auth::user(); // User yang sedang login adalah seller

        // Dapatkan saldo SoftPay penjual
        $sellerSoftpayBalance = $seller->softpay_balance ?? 0;

        // Dapatkan riwayat pemasukan terbaru untuk penjual
        // Asumsi 'SoftPayTransaction' memiliki 'user_id' untuk customer dan 'seller_id' untuk penjual (akan ditambahkan)
        // Atau, kita bisa memfilter berdasarkan 'type' yang menunjukkan pemasukan bagi penjual.
        // Untuk saat ini, kita akan memfilter transaksi SoftPay di mana penjual adalah penerima.
        // Anda perlu menambahkan `seller_id` ke tabel `soft_pay_transactions` atau mekanisme lain
        // untuk mengaitkan transaksi pendapatan dengan penjual.

        // ALTERNATIF: Ambil transaksi dari produk yang dijual oleh seller tersebut (jika Product memiliki relasi ke Transaction)
        // Ini adalah pendekatan yang lebih akurbat jika SoftPayTransaction hanya mencatat perubahan saldo individual.
        // Kita perlu tahu bagaimana detail transaksi (TransactionDetail) dikaitkan dengan produk dan seller.
        
        // Untuk demo, kita akan membuat data dummy atau mengasumsikan ada kolom `recipient_user_id` di SoftPayTransaction
        // atau kita akan menggunakan relasi `salesTransactions` yang ada di model User.

        // Mari kita asumsikan `SoftPayTransaction` memiliki kolom `recipient_user_id` untuk penerima dana.
        // Jika tidak, Anda perlu memodifikasi migrasi `soft_pay_transactions` dan modelnya.
        
        // Cek apakah 'seller_id' ada di SoftPayTransaction, jika tidak kita perlu modifikasi
        // Untuk sementara, kita akan menampilkan transaksi di mana user_id adalah seller dan tipenya adalah 'pemasukan'
        // Jika SoftPayTransaction hanya mencatat transaksi saldo pribadi (topup/withdraw), maka ini perlu diubah
        // menjadi join dengan tabel transaksi pembelian yang relevan.

        // Mengambil transaksi SoftPay yang merupakan pemasukan untuk seller (misal: dari penjualan)
        // Ini adalah placeholder dan perlu disesuaikan dengan struktur transaksi Anda.
        // Asumsi: 'type' = 'income_from_sale' atau 'Pemasukan Penjualan'
        $recentSellerTransactions = SoftPayTransaction::where('user_id', $seller->id)
                                                    ->where('type', 'Pemasukan Penjualan') // atau tipe lain yang relevan
                                                    ->orderBy('created_at', 'desc')
                                                    ->take(4)
                                                    ->get()
                                                    ->map(function ($transaction) {
                                                        return [
                                                            'type' => 'Pemasukan Penjualan', // Tipe yang disederhanakan untuk tampilan
                                                            'description' => $transaction->description ?: 'Pemasukan dari penjualan produk',
                                                            'date' => $transaction->created_at->diffForHumans(),
                                                            'amount' => $transaction->amount,
                                                        ];
                                                    });
        
        // Jika tidak ada transaksi pemasukan yang dicatat langsung di SoftPayTransaction untuk seller
        // Anda mungkin perlu mengambil data dari `TransactionDetail` yang terkait dengan produk seller.
        // Contoh placeholder jika transaksi riil belum ada di SoftPayTransaction
        if ($recentSellerTransactions->isEmpty()) {
            $recentSellerTransactions = collect([
                [
                    'type' => 'Pemasukan Penjualan',
                    'description' => 'Contoh: Penjualan produk A',
                    'date' => 'beberapa jam lalu',
                    'amount' => 150000,
                ],
                [
                    'type' => 'Pemasukan Penjualan',
                    'description' => 'Contoh: Penjualan produk B',
                    'date' => '1 hari lalu',
                    'amount' => 75000,
                ],
            ]);
        }


        return view('view-seller.softpay.softpay-seller', compact('sellerSoftpayBalance', 'recentSellerTransactions'));
    }

    /**
     * Menampilkan riwayat transaksi SoftPay lengkap untuk penjual.
     */
    public function history()
    {
        $seller = Auth::user();
        $transactions = SoftPayTransaction::where('user_id', $seller->id)
                                            ->whereIn('type', ['Pemasukan Penjualan', 'Penarikan Dana']) // Sesuaikan tipe transaksi seller
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(10); // Atau sesuai kebutuhan pagination

        $transactions->getCollection()->transform(function ($transaction) {
            return [
                'type' => ucfirst($transaction->type),
                'description' => $transaction->description ?: 'Transaksi SoftPay',
                'date' => $transaction->created_at->format('d M Y, H:i'),
                'amount' => $transaction->amount,
                'status' => ucfirst($transaction->status),
            ];
        });

        return view('view-seller.softpay.history', compact('transactions'));
    }

    /**
     * Menampilkan form penarikan dana untuk penjual.
     */
    public function showWithdrawForm()
    {
        $seller = Auth::user();
        $sellerSoftpayBalance = $seller->softpay_balance ?? 0;
        return view('view-seller.softpay.withdraw', compact('sellerSoftpayBalance'));
    }

    /**
     * Memproses permintaan penarikan dana dari penjual.
     */
    public function processWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:' . (Auth::user()->softpay_balance ?? 0),
            // Tambahkan validasi lain seperti rekening bank, dll.
        ]);

        $seller = Auth::user();
        $amount = $request->input('amount');

        if ($seller->softpay_balance < $amount) {
            return back()->withErrors(['amount' => 'Saldo SoftPay tidak mencukupi.']);
        }

        // Mulai transaksi database untuk menjaga konsistensi
        \DB::beginTransaction();
        try {
            // Kurangi saldo penjual
            $seller->softpay_balance -= $amount;
            $seller->save();

            // Catat transaksi penarikan di SoftPayTransaction
            SoftPayTransaction::create([
                'user_id' => $seller->id,
                'type' => 'Penarikan Dana', // Tipe penarikan
                'amount' => -$amount, // Jumlah negatif karena pengeluaran
                'description' => 'Penarikan dana SoftPay ke rekening bank.',
                'status' => 'pending', // Atau 'processing', akan diupdate setelah diproses manual/otomatis
                'reference_id' => 'WD-' . uniqid(), // ID referensi unik
            ]);

            // TODO: Tambahkan logika untuk memproses penarikan dana ke rekening bank penjual
            // Ini biasanya melibatkan sistem pembayaran eksternal atau proses manual.
            // Anda mungkin perlu tabel terpisah untuk `WithdrawalRequests`

            \DB::commit();

            return redirect()->route('seller.softpay.dashboard')->with('success', 'Permintaan penarikan dana berhasil diajukan.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses penarikan: ' . $e->getMessage());
        }
    }
}