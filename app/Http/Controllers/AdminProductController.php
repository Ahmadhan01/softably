<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with('seller');

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Apply sorting
    switch ($request->sort) {
        case 'lowest':
            $query->orderBy('price', 'asc');
            break;
        case 'highest':
            $query->orderBy('price', 'desc');
            break;
        case 'latest':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    $products = $query->paginate(10)->appends($request->all());

    return view('view-admin.view-produk-admin', compact('products'));
}


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('view-admin.edit-produk-admin', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
            'download_link' => 'nullable|string',
            'content_description' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
