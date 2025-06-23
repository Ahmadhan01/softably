<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Pastikan ini di-use jika Anda mengakses Product model
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $transactionsQuery = $user->transactions()->with('details.product');

        $statusFilter = $request->input('status', 'completed');
        if ($statusFilter !== 'all') {
            $transactionsQuery->where('status', $statusFilter);
        }

        $searchQuery = $request->input('search');
        if ($searchQuery) {
            $transactionsQuery->whereHas('details', function ($query) use ($searchQuery) {
                $query->where('product_name', 'like', '%' . $searchQuery . '%');
            });
        }

        $categoryFilter = $request->input('category');
        if ($categoryFilter) {
            $transactionsQuery->whereHas('details.product', function ($query) use ($categoryFilter) {
                $query->where('category', $categoryFilter);
            });
        }

        $transactionsQuery->latest('created_at');

        $transactions = $transactionsQuery->paginate(10);

        $categories = [
            '' => 'All Categories',
            'applications' => 'Applications',
            'digital_content' => 'Digital Content',
            'online_courses' => 'Online Courses',
            'digital_assets' => 'Digital Assets',
        ];

        return view('view-customer.order-customer', [
            'orders' => $transactions, // Mengirim sebagai 'orders' untuk konsistensi Blade
            'categories' => $categories,
            'selectedCategory' => $categoryFilter,
            'searchQuery' => $searchQuery,
            'selectedStatus' => $statusFilter,
        ]);
    }

    public function show(Transaction $transaction)
    {
        abort_unless($transaction->user_id === Auth::id(), 403);
        $transaction->load('details.product', 'details.product.comments.user'   );
        return view('view-customer.detailorder-customer', compact('transaction'));
    }
}