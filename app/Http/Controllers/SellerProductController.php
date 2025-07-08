<?php
namespace App\Http\Controllers;

use App\Models\Link; // Pastikan model Link di-import
use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Menampilkan daftar produk milik seller yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $seller   = Auth::user();
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
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'product_link'  => 'nullable|url|max:255',
            'price'         => 'required|numeric|min:0',
            'currency'      => 'required|string|max:10',
            'categories'    => 'required|array|min:1',
            'categories.*'  => 'string|max:50',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $seller = Auth::user();

        // Membuat instance produk baru
        $product               = new Product();
        $product->user_id      = $seller->id;
        $product->name         = $request->input('title');
        $product->description  = $request->input('description');
        $product->product_link = $request->input('product_link');
        $product->price        = $request->input('price');
        $product->currency     = $request->input('currency');
        $product->category     = implode(', ', $request->input('categories'));

        // Proses upload gambar jika ada
        if ($request->hasFile('product_image')) {
            $image        = $request->file('product_image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension    = $image->getClientOriginalExtension();

            $safeName  = Str::slug($originalName, '_') . '.' . $extension;
            $imageName = time() . '_' . $safeName;
            $imagePath = $image->storeAs('product_images', $imageName, 'public');

            $product->image_path = $imagePath;
        } else {
            $product->image_path = 'img/default-product.jpg';
        }

        $product->status = 'active';

        $product->save(); // Simpan produk ke database

        // --- START MODIFIKASI ---
        // Buat entri baru di tabel 'links' setelah produk berhasil disimpan
        if ($product->product_link) { // Hanya buat link jika product_link ada
            Link::create([
                'title'   => $product->name,
                'url'     => $product->product_link,
                'user_id' => $product->user_id,
                'status'  => 'active', // Atur status default untuk link
            ]);
        }
        // --- END MODIFIKASI ---

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
            'user',
            'comments.user',
            'comments.replies.user',
            'orderItems.transaction.user',
            'wishlists',
            'carts',
        ]);

        // Menghitung Product Sold
        $productSold = $product->orderItems->sum('quantity');

        // Menghitung Product Wishlist (jumlah user unik yang menambahkan ke wishlist)
        $productWishlistCount = $product->wishlists->count();

        // Menghitung Product Cart (jumlah user unik yang menambahkan ke keranjang)
        $productCartCount = $product->carts->count();

        // Mengambil riwayat transaksi: nama pengguna, email, nomor telepon
        $transactions = $product->orderItems->map(function ($orderItem) {
            return [
                'user_name'  => $orderItem->transaction->user->name,
                'user_email' => $orderItem->transaction->user->email,
                'user_phone' => $orderItem->transaction->user->phone_number ?? 'N/A',
            ];
        })->unique('user_email')->values();

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
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'product_link'  => 'nullable|url|max:255',
            'price'         => 'required|numeric|min:0',
            'currency'      => 'required|string|max:10',
            'categories'    => 'required|array|min:1',
            'categories.*'  => 'string|max:50',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data produk
        $product->name         = $request->input('title');
        $product->description  = $request->input('description');
        $product->product_link = $request->input('product_link');
        $product->price        = $request->input('price');
        $product->currency     = $request->input('currency');
        $product->category     = implode(', ', $request->input('categories'));

        // Proses update gambar jika ada
        if ($request->hasFile('product_image')) {
            // Hapus gambar lama jika ada dan bukan gambar default
            if ($product->image_path && Storage::disk('public')->exists($product->image_path) && $product->image_path !== 'img/default-product.jpg') {
                Storage::disk('public')->delete($product->image_path);
            }

            $image        = $request->file('product_image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension    = $image->getClientOriginalExtension();

            $safeName  = Str::slug($originalName, '_') . '.' . $extension;
            $imageName = time() . '_' . $safeName;
            $imagePath = $image->storeAs('product_images', $imageName, 'public');

            $product->image_path = $imagePath;
        }

        $product->save();

        // --- CATATAN: Kode ini sudah ada di metode update, jadi tidak perlu ditambahkan lagi di sini.
        // --- Namun, perlu dipastikan bahwa logika ini sesuai dengan kebutuhan Anda.
        // --- Jika Anda ingin link baru dibuat setiap kali produk diupdate, maka kode ini sudah benar.
        // --- Jika Anda ingin link hanya dibuat saat produk pertama kali dibuat, maka kode ini harus dihapus dari sini.
        // Link::create([
        //     'title'   => $product->name,
        //     'url'     => $product->product_link,
        //     'user_id' => $product->user_id,
        //     'status'  => 'active',
        // ]);
        // --- END CATATAN ---

        return redirect()->route('seller.products.details', $product->id)->with('success', 'Produk berhasil diperbarui!');
    }
}
