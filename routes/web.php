<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController; // Tambahkan ini
use App\Http\Controllers\WishlistController; // Tambahkan ini
use App\Http\Controllers\CartController; // Tambahkan ini
use App\Models\Product; // Tambahkan ini

use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Halaman utama (login)
Route::get('/', function () {
    return view('welcome');
});


// Dashboard (sudah ada)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// Profil pengguna (sudah ada)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('view-admin.dashboard-admin'))->name('admin.dashboard');
    Route::get('/seller/dashboard', fn() => view('view-seller.dashboard-seller'))->name('seller.dashboard');
    Route::get('/customer/produks', fn() => view('view-customer.produk-customer'))->name('customer.produk');
});


// Admin routes (sudah ada)
Route::get('/register-admin', function () {
    return view('view-admin/register-admin');
})->name('register-admin');
Route::get('/chart-admin', function () {
    return view('view-admin/chart-admin');
})->name('chart-admin');
Route::get('/faq-admin', function () {
    return view('view-admin/faq-admin');
})->name('faq-admin');


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
Route::get('/chat-customer', function () {
    return view('view-customer/chat-customer');
})->name('chat-customer');

Route::get('/checkout-customer', function () {
    return view('view-customer/checkout-customer');
})->name('checkout-customer');

Route::get('/detailorder-customer', function () {
    return view('view-customer/detailorder-customer');
})->name('detailorder-customer');

Route::get('/bantuan-customer', function () {
    return view('view-customer/bantuan-customer');
})->name('bantuan-customer');

Route::get('/landingpage-customer', function () {
    return view('view-customer/landingpage-customer');
})->name('landingpage-customer');

Route::get('/notif-customer', function () {
    return view('view-customer/notif-customer');
})->name('notif-customer');

Route::get('/order-customer', function () {
    return view('view-customer/order-customer');
})->name('order-customer');

Route::get('/setting-customer', function () {
    return view('view-customer/setting-customer');
})->name('setting-customer');

require __DIR__.'/auth.php';

