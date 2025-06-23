<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Middleware\TrackPageView;
use App\Http\Middleware\LogVisitTest;
use App\Http\Controllers\LinkController;
use App\Models\Link;


Route::get('/', function () {
    return view('landing-page');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', UpdateLastSeen::class, TrackPageView::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/seller/dashboard', fn() => view('view-seller.dashboard-seller'))->name('seller.dashboard');
    Route::get('/customer/produks', fn() => view('view-customer.produk-customer'))->name('customer.produk');
});

Route::get('/notif-admin', function () {
    return view('view-admin.notif-admin');
});

Route::get('/setting-admin', function () {
    return view('view-admin.setting-admin');
});


Route::prefix('admin')->group(function () {
    Route::get('/setting-app', [AdminSettingController::class, 'appSettings'])->name('admin.settings.app');
    Route::post('/setting-app', [AdminSettingController::class, 'updateAppSettings'])->name('admin.settings.update');
});


Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
    Route::get('/table-user', [UserController::class, 'index'])->name('admin.user.index');
});


Route::get('/view-produk', function () {
    return view('view-admin.view-produk-admin');
});

Route::get('/helpcenter-admin', function () {
    return view('view-admin.helpcenter-admin');
});
Route::get('/manage-complain', function () {
    return view('view-admin.manage-complain-admin');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
});

Route::middleware(['auth'])->group(function () {
    Route::put('/admin/setting/update', [AdminSettingController::class, 'update'])->name('admin.setting.update');
});

Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
    Route::get('/admin/links', [LinkController::class, 'index'])->name('admin.links.index');
    Route::post('/links/{link}/block', [LinkController::class, 'block'])->name('links.block');
    Route::post('/links/{link}/activate', [LinkController::class, 'activate'])->name('links.activate');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
});


Route::get('/go/{id}', function ($id) {
    $link = \App\Models\Link::where('id', $id)
        ->where('status', 'active') 
        ->firstOrFail();

    $link->increment('clicks');
    return redirect()->away($link->url);
})->name('link.redirect');


