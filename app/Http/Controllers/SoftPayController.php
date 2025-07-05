<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini diimpor
use App\Models\SoftPayTransaction;

class SoftPayController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil Saldo SoftPay dari user yang login
        // Pastikan kolom 'softpay_balance' ada di tabel 'users' dan diisi
        $softpayBalance = $user->softpay_balance ?? 0; // Menggunakan null coalescing operator jika saldo belum ada

        // 2. Ambil Riwayat Transaksi Terbaru dari database
        // Ambil 5 transaksi SoftPay terakhir untuk user ini
        $recentTransactions = SoftPayTransaction::where('user_id', $user->id)
                                                ->orderBy('created_at', 'desc')
                                                ->take(4) // Ambil 4 transaksi sesuai tampilan Anda
                                                ->get()
                                                ->map(function ($transaction) {
                                                    // Format data agar sesuai dengan yang diharapkan di blade
                                                    return [
                                                        'type' => ucfirst($transaction->type), // capitalize type (e.g., 'purchase' -> 'Purchase')
                                                        'description' => $transaction->description,
                                                        'date' => $transaction->created_at->diffForHumans(), // '2 days ago'
                                                        'amount' => $transaction->amount,
                                                    ];
                                                });
        // Logika untuk menampilkan deskripsi jika kosong
        // if ($transaction->description === null) {
        //     $transaction->description = 'Transaksi ' . ucfirst($transaction->type);
        // }


        return view('view-customer.softpay-customer', compact('softpayBalance', 'recentTransactions'));
    }

    // Anda akan membuat metode lain di sini untuk topup, withdraw, pay, dll.
    // public function topup() { /* ... */ }
    // public function withdraw() { /* ... */ }
    // public function pay() { /* ... */ }
    // public function transfer() { /* ... */ }
    // public function history() { /* ... */ }
    // public function promo() { /* ... */ }
    // public function help() { /* ... */ }
}