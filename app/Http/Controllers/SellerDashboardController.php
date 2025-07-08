<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon; // Untuk memudahkan manipulasi tanggal

class SellerDashboardController extends Controller
{
    /**
     * Menampilkan dashboard seller dengan data statistik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $seller = Auth::user(); // Mendapatkan user seller yang sedang login

        // 1. Product Sold (Total Kuantitas Produk yang Terjual)
        // Menjumlahkan kuantitas dari semua transaction_details yang terkait dengan produk seller.
        $totalProductSold = TransactionDetail::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->sum('quantity');


        // 2. Total Revenue (Total Pendapatan)
        // Menghitung total (quantity * price_at_transaction) untuk semua transaction_details
        // yang terkait dengan produk seller.
        $totalRevenue = TransactionDetail::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->get()->sum(function($detail) {
            return $detail->quantity * $detail->price_at_transaction;
        });


        // 3. Monthly Transactions (Jumlah Transaksi Bulanan)
        // Menghitung jumlah transaksi unik yang melibatkan produk seller di bulan ini.
        $monthlyTransactionsCount = Transaction::whereHas('details.product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

        // --- Data untuk Grafik ---

        // Data untuk Grafik Total Revenue (Area Chart) - Last 12 Months
        $revenueChartData = $this->getMonthlyRevenueData($seller);

        // Data untuk Grafik Product Sold (Bar Chart) - Last 12 Months
        $productSoldChartData = $this->getMonthlyProductSoldData($seller);

        // Data untuk Grafik Monthly Transaction (Line Chart) - Last 12 Months (Jumlah Pengguna Unik)
        $monthlyTransactionChartData = $this->getMonthlyUniqueUsersData($seller);

        // --- Placeholder untuk persentase perubahan (Anda perlu logika riil di sini) ---
        // Untuk menghitung perubahan, Anda perlu membandingkan data periode sekarang dengan periode sebelumnya.
        // Contoh sederhana:
        $prevTotalProductSold = TransactionDetail::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->whereMonth('created_at', Carbon::now()->subMonth()->month)
          ->whereYear('created_at', Carbon::now()->subMonth()->year)
          ->sum('quantity');

        $productSoldChange = $this->calculatePercentageChange($prevTotalProductSold, $totalProductSold);


        $prevTotalRevenue = TransactionDetail::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->whereMonth('created_at', Carbon::now()->subMonth()->month)
          ->whereYear('created_at', Carbon::now()->subMonth()->year)
          ->get()->sum(function($detail) {
              return $detail->quantity * $detail->price_at_transaction;
          });

        $totalRevenueChange = $this->calculatePercentageChange($prevTotalRevenue, $totalRevenue);


        $prevMonthlyTransactionsCount = Transaction::whereHas('details.product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })
        ->whereMonth('created_at', Carbon::now()->subMonth()->month)
        ->whereYear('created_at', Carbon::now()->subMonth()->year)
        ->count();

        $monthlyTransactionsChange = $this->calculatePercentageChange($prevMonthlyTransactionsCount, $monthlyTransactionsCount);

        // Pastikan variabel 'monthlyTransactionCountValue' dikirim
        $monthlyTransactionCountValue = $monthlyTransactionsCount; // Menggunakan nilai aktual dari $monthlyTransactionsCount

        return view('view-seller.dashboard-seller', compact(
            'totalProductSold',
            'totalRevenue',
            'monthlyTransactionsCount',
            'productSoldChange',
            'totalRevenueChange',
            'monthlyTransactionsChange',
            'monthlyTransactionCountValue',
            'revenueChartData', // Ubah nama variabel agar konsisten dengan view
            'productSoldChartData',
            'monthlyTransactionChartData'
        ));
    }

    /**
     * Helper function to calculate percentage change.
     */
    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? '+100%' : '0%'; // Jika sebelumnya 0, dan sekarang ada, anggap 100% naik
        }
        $change = (($newValue - $oldValue) / $oldValue) * 100;
        return ($change >= 0 ? '+' : '') . round($change, 1) . '%';
    }


    /**
     * Mengambil data pendapatan bulanan untuk chart.
     */
        private function getMonthlyRevenueData($seller)
        {
            $months = [];
            $revenues = [];
            // Loop untuk 12 bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthName = $date->format('M'); // Jan, Feb, Mar
                $year = $date->format('Y');

                $monthlyRevenue = TransactionDetail::whereHas('product', function($query) use ($seller) {
                    $query->where('user_id', $seller->id);
                })
                ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->get()
            ->sum(function($detail) {
                return $detail->quantity * $detail->price_at_transaction;
            });

            $months[] = $monthName;
            $revenues[] = round($monthlyRevenue); // Round untuk chart
        }
        return ['months' => $months, 'revenues' => $revenues];
    }

    /**
     * Mengambil data penjualan produk bulanan untuk chart.
     */
    private function getMonthlyProductSoldData($seller)
    {
        $months = [];
        $currentMonthSales = [];
        $previousYearSales = []; // Ubah nama variabel agar lebih jelas

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i); // Bulan saat ini dalam iterasi loop (misal: Juli 2025)
            $monthName = $date->format('M');

            $soldCurrentMonth = TransactionDetail::whereHas('product', function($query) use ($seller) {
                $query->where('user_id', $seller->id);
            })
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('quantity');

            // Untuk 'Old Profit', ambil data dari bulan yang SAMA di TAHUN SEBELUMNYA
            $prevYearDate = $date->copy()->subYear(); // Ambil bulan yang sama, tapi tahun sebelumnya
            $soldPreviousYear = TransactionDetail::whereHas('product', function($query) use ($seller) {
                $query->where('user_id', $seller->id);
            })
            ->whereMonth('created_at', $prevYearDate->month)
            ->whereYear('created_at', $prevYearDate->year)
            ->sum('quantity');

            $months[] = $monthName;
            $currentMonthSales[] = $soldCurrentMonth;
            $previousYearSales[] = $soldPreviousYear; // Data untuk 'Old Profit'
        }

        return [
            'months' => $months,
            'newProfit' => $currentMonthSales,
            'oldProfit' => $previousYearSales, // Sesuaikan namanya di sini juga
        ];
    }

    /**
     * Mengambil data jumlah user unik yang melakukan transaksi bulanan untuk chart.
     */
    private function getMonthlyUniqueUsersData($seller)
    {
        $months = [];
        $uniqueUsersCount = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');

            $count = Transaction::whereHas('details.product', function($query) use ($seller) {
                $query->where('user_id', $seller->id);
            })
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->distinct('user_id') // Menghitung user_id yang unik
            ->count('user_id');

            $months[] = $monthName;
            $uniqueUsersCount[] = $count;
        }
        return ['months' => $months, 'users' => $uniqueUsersCount];
    }
}