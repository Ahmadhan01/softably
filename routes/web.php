<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController; // Tambahkan ini
use App\Http\Controllers\WishlistController; // Tambahkan ini
use App\Http\Controllers\CartController; // Tambahkan ini
use App\Models\Product; // Tambahkan ini


// Halaman utama (login)
Route::get('/', function () {
    return view('auth/login');
});

// Dashboard (sudah ada)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil pengguna (sudah ada)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CUSTOMER ROUTES

// Rute untuk Halaman Daftar Produk Customer
// ***PENTING: Ubah ini menjadi ProductController@index***
Route::get('/produk-customer', [ProductController::class, 'index'])
    ->name('produk-customer.index');

// Rute untuk Halaman Detail Produk Customer
Route::get('/view-product/{product}', function (Product $product) {
    return view('view-customer.viewproduk-customer', compact('product'));
})->name('view-product.show');

// Rute Komentar
Route::post('/comments/{product}', [CommentController::class, 'store'])
    ->middleware('auth') // Hanya user terautentikasi yang bisa berkomentar
    ->name('comments.store'); // PASTIKAN NAMA RUTE INI ADALAH 'comments.store'

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth') // Hanya user terautentikasi yang bisa menghapus
    ->name('comments.destroy');

// Rute Wishlist
Route::middleware('auth')->group(function () {
    Route::get('/wishlist-customer', [WishlistController::class, 'index'])->name('wishlist-customer.index'); // Halaman wishlist
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store'); // Tambah/Hapus dari wishlist
    // Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy'); // Jika perlu hapus per item dari halaman wishlist
});


// Rute Cart
Route::middleware('auth')->group(function () {
    Route::get('/cart-customer', [CartController::class, 'index'])->name('cart-customer.index'); // Halaman keranjang
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store'); // Tambah/update ke keranjang
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update'); // Update kuantitas
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy'); // Hapus item dari keranjang
});

// Rute-rute customer lainnya (sudah ada, tambahkan nama rute yang benar jika belum)

Route::get('/chart-admin', function () {
    return view('view-admin/chart-admin');
})->name('chart-admin');

Route::get('/dashboard-admin', function () {
    return view('view-admin/dashboard-admin');
})->name('dashboard-admin');

Route::get('/faq-admin', function () {
    return view('view-admin/faq-admin');
})->name('faq-admin');

Route::get('/login-admin', function () {
    return view('view-admin/login-admin');
})->name('login-admin');

Route::get('/register-admin', function () {
    return view('view-admin/register-admin');
})->name('register-admin');

Route::get('/notif-admin', function () {
    return view('view-admin/notif-admin');
})->name('notif-admin');

Route::get('/produk-admin', function () {
    return view('view-admin/produk-admin');
})->name('produk-admin');

Route::get('/setting-admin', function () {
    return view('view-admin/setting-admin');
})->name('setting-admin');

Route::get('/table_user-admin', function () {
    return view('view-admin/table_user-admin');
})->name('table_user-admin');


// Route buat View-Seller

Route::get('/Dashboard-seller', function () {
    return view('/view-seller/Dashboard-seller');
})->middleware(['auth', 'verified'])->name('Dashboard');

Route::get('/My-product-seller', function () {
    return view('/view-seller/My-product-seller');
})->middleware(['auth', 'verified'])->name('My-product');

Route::get('/Chat-seller', function () {
    return view('/view-seller/Chat-seller');
})->middleware(['auth', 'verified'])->name('Chat-seller');

Route::get('/Notification-seller', function () {
    return view('/view-seller/Notification-seller');
})->middleware(['auth', 'verified'])->name('Notification-seller');

Route::get('/Help-Center-seller', function () {
    return view('/view-seller/Help-Center-seller');
})->middleware(['auth', 'verified'])->name('Help-Center-seller');

Route::get('/Settings-seller', function () {
    return view('/view-seller/Settings-seller');
})->middleware(['auth', 'verified'])->name('Settings-seller');

Route::get('/Details-Product-seller', function () {
    return view('/view-seller/Details-Product-seller');
})->middleware(['auth', 'verified'])->name('Details-Product-seller');

Route::get('/Add-Product-seller', function () {
    return view('/view-seller/Add-Product-seller');
})->middleware(['auth', 'verified'])->name('Add-Product-seller');

Route::get('/Edit-Product-seller', function () {
    return view('/view-seller/Edit-Product-seller');
})->middleware(['auth', 'verified'])->name('Edit-Product-seller');


require __DIR__.'/auth.php';
