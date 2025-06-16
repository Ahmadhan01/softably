<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Pastikan user sudah login
        // Middleware 'auth' di route sudah menangani ini, tapi bisa double check
        if (!Auth::check()) {
            return back()->with('error', 'Anda harus login untuk berkomentar.');
        }

        // Buat komentar baru
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Metode untuk menghapus komentar (opsional, tambahkan otorisasi)
    public function destroy(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang bisa menghapus
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Atau return back()->with('error', 'Tidak berhak menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}