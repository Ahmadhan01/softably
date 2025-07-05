<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerNotification; // Import model baru
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\User; // Perlu model User untuk relasi seller

class SellerNotificationController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        if (!$seller || $seller->role !== 'seller') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Anda harus login sebagai penjual.');
        }

        // Ambil notifikasi untuk penjual ini, urutkan berdasarkan yang terbaru
        // Eager load transactionDetail, product (melalui transactionDetail), dan transaction (melalui transactionDetail -> transaction)
        $notifications = SellerNotification::where('seller_id', $seller->id)
                                        ->with([
                                            'transactionDetail.product',
                                            'transactionDetail.transaction.user'
                                        ])
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        return view('view-seller.notif-seller', compact('notifications'));
    }

    public function markAllAsRead(Request $request)
    {
        $seller = Auth::user();

        if (!$seller || $seller->role !== 'seller') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        SellerNotification::where('seller_id', $seller->id)
                          ->where('is_read', false)
                          ->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sebagai sudah dibaca.']);
    }

    public function markAsRead(Request $request, SellerNotification $notification)
    {
        // Pastikan notifikasi ini milik penjual yang sedang login
        if ($notification->seller_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->is_read = true;
        $notification->save();

        return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sebagai sudah dibaca.']);
    }

    /**
     * Metode untuk membuat notifikasi baru (akan dipanggil saat transaksi selesai)
     * Anda bisa memanggil ini dari TransactionController atau service yang menangani penyelesaian transaksi.
     */
    public static function createTransactionNotification(TransactionDetail $transactionDetail)
    {
        // Pastikan produk dan penjualnya ada
        $product = $transactionDetail->product;
        $seller = $product->user; // User yang memiliki produk adalah penjual

        if (!$product || !$seller) {
            return; // Tidak bisa membuat notifikasi jika data tidak lengkap
        }

        $buyerName = $transactionDetail->transaction->user->name ?? 'Pembeli Tidak Ditemukan';
        $invoiceNumber = $transactionDetail->transaction->invoice_number ?? 'N/A';
        $productName = $transactionDetail->product->name ?? 'Produk Tidak Ditemukan';
        $totalPrice = ($transactionDetail->price_per_unit ?? 0) * ($transactionDetail->quantity ?? 0);

        SellerNotification::create([
            'seller_id' => $seller->id,
            'transaction_detail_id' => $transactionDetail->id,
            'type' => 'transaction_alert',
            'title' => 'Pembelian Berhasil!',
            'message' => "Produk $productName oleh $buyerName dengan invoice $invoiceNumber telah diproses. Jumlah: {$transactionDetail->quantity} | Total Harga per item: Rp" . number_format($transactionDetail->price_per_unit, 0, ',', '.') . " | Subtotal: Rp" . number_format($totalPrice, 0, ',', '.'),
            'is_read' => false,
        ]);
    }
}