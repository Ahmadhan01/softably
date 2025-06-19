<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard-seller', function () {
    return view('/view-seller/dashboard-seller');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/My-product-seller', function () {
    return view('/view-seller/My-product-seller');
})->middleware(['auth', 'verified'])->name('My-product');

Route::get('/Chat-seller', function () {
    return view('/view-seller/Chat-seller');
})->middleware(['auth', 'verified'])->name('Chat-seller');

Route::get('/Notification-seller', function () {
    return view('/view-seller/Notifikasi-seller');
})->middleware(['auth', 'verified'])->name('Notifikasi-seller');

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

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('view-admin.dashboard-admin'))->name('admin.dashboard');
    Route::get('/seller/dashboard', fn() => view('view-seller.dashboard-seller'))->name('seller.dashboard');
    Route::get('/customer/produks', fn() => view('view-customer.produk-customer'))->name('customer.produk');
});

