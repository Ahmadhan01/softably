<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Asumsi Anda memiliki model Product
use Illuminate\Support\Facades\Storage; // Penting untuk menyimpan gambar
use Illuminate\Support\Str; 
use App\Models\User; // Pastikan User model di-import
use App\Models\TransactionDetail; // Pastikan TransactionDetail model di-import

class SellerProductController extends Controller
{
    /**
     * Menampilkan daftar produk milik seller yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $seller = Auth::user();
        $products = $seller->products()->get();
        return view('view-seller.my-products-seller', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('view-seller.add-product-seller');
    }

    /**
     * Menyimpan produk baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_link' => 'nullable|url|max:255', // Validasi untuk product_link
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10', // Validasi untuk currency
            'categories' => 'required|array|min:1', // Validasi untuk setidaknya satu kategori dipilih
            'categories.*' => 'string|max:50', // Validasi setiap item dalam array kategori
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, format gambar
        ]);

        $seller = Auth::user();

        // Membuat instance produk baru
        $product = new Product();
        $product->user_id = $seller->id; // user_id dari seller yang login
        $product->name = $request->input('title'); // 'title' dari form masuk ke 'name' di tabel products
        $product->description = $request->input('description');
        $product->product_link = $request->input('product_link'); // Simpan product_link
        $product->price = $request->input('price');
        $product->currency = $request->input('currency'); // Simpan currency

        // Menggabungkan array kategori menjadi string yang dipisahkan koma
        // Pastikan Anda memiliki kolom 'category' bertipe string/varchar di database
        $product->category = implode(', ', $request->input('categories')); // Simpan kategori

        // Proses upload gambar jika ada
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            // Bersihkan nama file: ganti spasi dengan underscore, hapus karakter non-alphanumeric, dan buat lowercase
            $safeName = Str::slug($originalName, '_') . '.' . $extension; // Menggunakan Str::slug
            $imageName = time() . '_' . $safeName; // Tambahkan timestamp
            $imagePath = $image->storeAs('product_images', $imageName, 'public');

            $product->image_path = $imagePath;      
        } else {
            // Opsional: Atur gambar default jika tidak ada gambar yang diunggah
            $product->image_path = 'img/default-product.jpg'; // Pastikan path ini benar
        }

        $product->status = 'active'; // Ganti 'available' dengan 'active'
        // $product->sales_count = 0; // Atur sales_count default jika diperlukan

        $product->save(); // Simpan produk ke database

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        // Pastikan produk ini milik seller yang sedang login
        // Ini penting untuk keamanan.
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Memuat semua relasi yang diperlukan secara efisien
        $product->load([
            'user', // Pemilik produk (seller)
            'comments.user', // Komentar utama beserta user yang berkomentar
            'comments.replies.user', // Balasan komentar beserta user yang membalas
            'orderItems.transaction.user', // Untuk riwayat transaksi: item pesanan -> transaksi -> user pembeli
            'wishlists', // Cukup load relasi wishlists
            'carts', // Cukup load relasi carts
        ]);

        // Menghitung Product Sold
        // Ini akan menjumlahkan kuantitas dari semua TransactionDetail yang terkait dengan produk ini.
        $productSold = $product->orderItems->sum('quantity');

        // Menghitung Product Wishlist (jumlah user unik yang menambahkan ke wishlist)
        $productWishlistCount = $product->wishlists->count();

        // Menghitung Product Cart (jumlah user unik yang menambahkan ke keranjang)
        $productCartCount = $product->carts->count();

        // Mengambil riwayat transaksi: nama pengguna, email, nomor telepon
        // Mengambil detail transaksi dari orderItems dan memastikan pengguna unik
        $transactions = $product->orderItems->map(function ($orderItem) {
            return [
                'user_name' => $orderItem->transaction->user->name,
                'user_email' => $orderItem->transaction->user->email,
                'user_phone' => $orderItem->transaction->user->phone_number ?? 'N/A', // Pastikan phone_number ada di User model
            ];
        })->unique('user_email')->values(); // Hanya ambil entri unik berdasarkan email pengguna

        return view('view-seller.details-product-seller', compact(
            'product',
            'productSold',
            'productWishlistCount',
            'productCartCount',
            'transactions'
        ));
    }

    public function edit(Product $product)
    {
        // Pastikan produk ini milik seller yang sedang login
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Jika kategori disimpan sebagai string dipisahkan koma, pisahkan kembali menjadi array
        $product->categories = explode(', ', $product->category);

        return view('view-seller.edit-product-seller', compact('product'));
    }

    /**
     * Memperbarui produk yang sudah ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        // Pastikan produk ini milik seller yang sedang login
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data yang masuk
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_link' => 'nullable|url|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'categories' => 'required|array|min:1',
            'categories.*' => 'string|max:50',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data produk
        $product->name = $request->input('title');
        $product->description = $request->input('description');
        $product->product_link = $request->input('product_link');
        $product->price = $request->input('price');
        $product->currency = $request->input('currency');
        $product->category = implode(', ', $request->input('categories'));

        // Proses update gambar jika ada
        if ($request->hasFile('product_image')) {
            // Hapus gambar lama jika ada dan bukan gambar default
            if ($product->image_path && Storage::disk('public')->exists($product->image_path) && $product->image_path !== 'img/default-product.jpg') {
                Storage::disk('public')->delete($product->image_path);
            }

            $image = $request->file('product_image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $safeName = Str::slug($originalName, '_') . '.' . $extension;
            $imageName = time() . '_' . $safeName;
            $imagePath = $image->storeAs('product_images', $imageName, 'public');

            $product->image_path = $imagePath;
        }

        $product->save();

        return redirect()->route('seller.products.details', $product->id)->with('success', 'Produk berhasil diperbarui!');
    }
}