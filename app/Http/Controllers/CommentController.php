<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade untuk logging error

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Validasi parent_id
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk berkomentar.'], 401);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'), // Simpan parent_id
        ]);

        return response()->json(['success' => true, 'message' => 'Komentar berhasil ditambahkan!']);
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk membalas komentar.'], 401);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $comment->product_id, // Balasan terkait dengan produk yang sama
            'content' => $request->input('content'),
            'parent_id' => $comment->id, // ID komentar yang dibalas
        ]);

        return response()->json(['success' => true, 'message' => 'Balasan berhasil ditambahkan!']);
    }


    public function update(Request $request, Comment $comment)
    {
        // Pastikan request datang sebagai JSON dari AJAX
        if ($request->expectsJson()) {
            if ($comment->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak berhak memperbarui komentar ini.'], 403);
            }

            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            $comment->content = $request->input('content');
            $comment->save();

            return response()->json(['success' => true, 'message' => 'Komentar berhasil diperbarui!']);

        } else {
            // Fallback untuk non-AJAX request
            if ($comment->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak berhak memperbarui komentar ini.');
            }

            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            $comment->content = $request->input('content');
            $comment->save();

            return back()->with('success', 'Komentar berhasil diperbarui!');
        }
    }

    public function destroy(Comment $comment)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk menghapus komentar.'], 401);
        }

        $product = $comment->product;

        if ($comment->user_id !== Auth::id() && (!($product && $product->user_id === Auth::id()))) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
        }

        try {
            $comment->replies()->delete();
            $comment->delete();

            return response()->json(['success' => true, 'message' => 'Komentar dan balasannya berhasil dihapus.']);

        } catch (\Exception $e) {
            Log::error('Error deleting comment: ' . $e->getMessage(), ['comment_id' => $comment->id, 'user_id' => Auth::id()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus komentar.'], 500);
        }
    }
}       