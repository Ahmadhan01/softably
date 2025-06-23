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
        if (!Auth::check()) {
            // Untuk AJAX, kembalikan JSON error daripada redirect back()
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk berkomentar.'], 401);
        }

        // Buat komentar baru
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'content' => $request->input('content'),
        ]); 

        // *** PERBAIKI INI: Kembalikan respons JSON ***
        return response()->json(['success' => true, 'message' => 'Komentar berhasil ditambahkan!']);
    }

    public function update(Request $request, Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang bisa mengedit
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->content = $request->input('content');
        $comment->save();

        // Respon JSON untuk AJAX
        return response()->json(['success' => true, 'message' => 'Komentar berhasil diperbarui!']);
    }

    // Metode untuk menghapus komentar (opsional, tambahkan otorisasi)
    public function destroy(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang bisa menghapus
        if ($comment->user_id !== Auth::id()) {
            // Mengembalikan JSON error jika tidak berhak
            return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
        }

        try {
            $comment->delete();
            // Kembalikan respons JSON sukses
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus dari DB
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus komentar dari database.'], 500);
        }
    }
}