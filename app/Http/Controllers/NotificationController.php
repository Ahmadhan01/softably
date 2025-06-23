<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil semua notifikasi untuk user yang sedang login, urutkan dari terbaru
        $notifications = Notification::where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10); // Paginate untuk 10 notifikasi per halaman

        return view('view-customer.notif-customer', compact('notifications'));
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        Notification::where('user_id', $user->id)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    // Optional: Mark single notification as read (jika Anda memiliki tombol "Check" per notifikasi)
    public function markAsRead(Notification $notification)
    {
        // Pastikan notifikasi ini milik user yang sedang login
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->is_read = true;
        $notification->save();

        return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sudah dibaca.']);
    }
}