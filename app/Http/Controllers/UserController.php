<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Tetap kirim statistik ke view
        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        return view('view-admin.table-user-admin', compact('users', 'totalUsers', 'newUsers'));
    }

    public function ban(User $user)
    {
        $user->is_banned = true;
        $user->save();

        return back()->with('success', 'User has been banned.');
    }

    public function unban(User $user)
    {
        $user->is_banned = false;
        $user->save();

        return back()->with('success', 'User has been unbanned.');
    }
}
