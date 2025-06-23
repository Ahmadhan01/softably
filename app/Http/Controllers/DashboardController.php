<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;
use App\Models\Pageview;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasbor
        $totalSellers = User::where('role', 'seller')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalLinks = Link::count();
        $blockedLinks = Link::where('status', 'blocked')->count();
        $latestSellers = User::where('role', 'seller')->latest()->take(5)->get();
        $latestLinks = Link::with('user')->latest()->take(5)->get();

        // Statistik tambahan
        $pageviews = Pageview::whereMonth('created_at', now()->month)->count(); // ✅ ganti viewed_at ke created_at

        $monthlyUsers = User::whereMonth('created_at', now()->month)->count();
        $newSignups = User::whereDate('created_at', now())->count();
        $monthlyTransactions = Transaction::whereMonth('created_at', now()->month)->count();

        // Grafik 7 hari terakhir
        $labels = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $labels[] = Carbon::now()->subDays($i)->format('D');

            $count = Pageview::whereDate('created_at', $date)->count(); // ✅ ganti viewed_at ke created_at
            $values[] = $count;
        }

        return view('view-admin.dashboard-admin', compact(
            'totalSellers',
            'totalCustomers',
            'totalLinks',
            'blockedLinks',
            'latestSellers',
            'latestLinks',
            'pageviews',
            'monthlyUsers',
            'newSignups',
            'monthlyTransactions',
            'labels',
            'values'
        ));
    }
}
