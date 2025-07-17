<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SellerSettingController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SellerNotificationController;
use App\Http\Controllers\SoftPayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Middleware\TrackPageView;
use App\Http\Controllers\LinkController;
use App\Models\Link;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerSoftpayController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProfileController; // Tambahkan ini jika belum ada

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return view('view-admin.dashboard-admin');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/chat', [ChatController::class, 'sellerChat'])->name('chat'); // Rute untuk halaman chat seller

    Route::get('/bantuan-seller', function () {
        $loggedInUser = Auth::user();
        return view('view-seller/bantuan-seller', compact('loggedInUser'));
    })->name('bantuan-seller');

    // Rute untuk seller chat dengan admin (INI HANYA UNTUK VIEW JIKA ADA)
    // Jika fetchMessagesWithAdmin dan sendMessageToAdmin digunakan untuk AJAX,
    // maka endpoint API-nya harus ada di api.php seperti yang sudah kita lakukan.
    Route::get('/seller/chat/history', [ChatController::class, 'fetchMessagesWithAdminPage'])->name('seller.chat.history'); // Contoh: jika ini mengembalikan view
    Route::post('/seller/chat/send', [ChatController::class, 'sendMessageToAdminPost'])->name('seller.chat.send'); // Contoh: jika ini memproses form dan redirect

    // Rute untuk daftar produk seller
    Route::get('/seller/products', [SellerProductController::class, 'index'])->name('seller.products.index');
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('seller.products.store');
    Route::get('/seller/products/{product}/details', [SellerProductController::class, 'show'])->name('seller.products.details');
    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/seller/products/{product}', [SellerProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/notif-seller', [SellerNotificationController::class, 'index'])->name('notif-seller');
    Route::post('/notif-seller/mark-all-as-read', [SellerNotificationController::class, 'markAllAsRead'])->name('notif-seller.markAllAsRead');
    Route::post('/notif-seller/{notification}/mark-as-read', [SellerNotificationController::class, 'markAsRead'])->name('notif-seller.markAsRead');

    Route::get('/seller/softpay', [SellerSoftpayController::class, 'index'])->name('seller.softpay.dashboard');
    Route::get('/seller/softpay/history', [SellerSoftpayController::class, 'history'])->name('seller.softpay.history');
    Route::get('/seller/softpay/withdraw', [SellerSoftpayController::class, 'showWithdrawForm'])->name('seller.softpay.withdraw');
    Route::post('/seller/softpay/withdraw', [SellerSoftpayController::class, 'processWithdraw'])->name('seller.softpay.processWithdraw');

    Route::get('/settings', [SellerProfileController::class, 'index'])->name('seller.settings');
    Route::post('/settings/personal', [SellerProfileController::class, 'updatePersonal'])->name('seller.settings.updatePersonal');
    Route::post('/settings/picture', [SellerProfileController::class, 'updateProfilePicture'])->name('seller.settings.updateProfilePicture');
    Route::post('/settings/password', [SellerProfileController::class, 'updatePassword'])->name('seller.settings.updatePassword');
});

// Middleware auth (ini adalah group middleware yang lebih umum)
Route::middleware(['auth'])->group(function () {
    Route::get('/setting-seller', [SellerSettingController::class, 'index'])->name('seller.setting');
    Route::put('/seller/setting', [SellerSettingController::class, 'update'])->name('seller.setting.update');
    Route::put('/seller/setting/password', [SellerSettingController::class, 'updatePassword'])->name('seller.setting.updatePassword');

    // Rute chat yang mengembalikan VIEW, atau redirect
    // Chat with seller redirect bisa tetap di web.php
    Route::get('/chat/with-seller/{seller}', [ChatController::class, 'chatWithSellerRedirect'])->name('chat.withSellerRedirect');
});

// Comment routes
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::post('/comments/{product}', [CommentController::class, 'store'])->name('comments.store');
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/view-product/{product}', function (Product $product) {
        $product->load([
            'user',
            'comments' => function ($query) {
                $query->whereNull('parent_id')->with(['user', 'replies.user']);
            }
        ]);
        return view('view-customer.viewproduk-customer', compact('product'));
    })->name('view-product.show');

    //rute wishlist
    Route::get('/wishlist-customer', [WishlistController::class, 'index'])->name('wishlist-customer.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product_id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Rute Cart
    Route::get('/cart-customer', [CartController::class, 'index'])->name('cart-customer.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/multiple', [CartController::class, 'destroyMultiple'])->name('cart.destroy.multiple');

    Route::post('/cart/process-to-checkout', [CartController::class, 'processToCheckout'])->name('cart.processToCheckout');

    // Rute Checkout (method GET untuk menampilkan, method POST untuk memproses pembelian)
    Route::get('/checkout-customer', [CheckoutController::class, 'index'])->name('checkout-customer.index');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/prepare-checkout', [CartController::class, 'prepareCheckout'])->name('prepare.checkout');
    Route::post('/checkout/softpay', [CheckoutController::class, 'processSoftPayPayment'])->name('checkout.softpay');

    // Rute Notifikasi (Hanya satu definisi ini yang benar)
    Route::get('/notif-customer', [NotificationController::class, 'index'])->name('notif-customer');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    Route::post('/clear-checkout-session', function (Illuminate\Http\Request $request) {
        $request->session()->forget('selected_cart_items_for_checkout');
        return response()->json(['message' => 'Checkout session cleared.']);
    })->name('clear.checkout.session');

    // Rute CHAT BARU (ini untuk halaman VIEW chat customer)
    Route::get('/chat-customer', [ChatController::class, 'index'])->name('chat-customer');

    //rute bantuan
    Route::get('/bantuan-customer', function () {
        $loggedInUser = Auth::user();
        return view('view-customer/bantuan-customer', compact('loggedInUser'));
    })->name('bantuan-customer');

    // Rute untuk Halaman Pengaturan Profil (Customer)
    Route::get('/setting-customer', [ProfileController::class, 'index'])->name('setting-customer');
    Route::post('/profile/personal', [ProfileController::class, 'updatePersonal'])->name('profile.updatePersonal');
    Route::post('/profile/picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.updateProfilePicture');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Rute My Order
    Route::get('/order-customer', [OrderController::class, 'index'])->name('order-customer');
    Route::get('/order-customer/{transaction}', [OrderController::class, 'show'])->name('order-customer.show');

    Route::get('/landingpage-customer', function () {
        return view('view-customer/landingpage-customer');
    })->name('landingpage-customer');

    Route::get('/seller-profile/{user}', function (User $user) {
        if ($user->role !== 'seller') {
            abort(404);
        }
        $products = $user->products()->get();
        return view('view-customer.seller-profile', compact('user', 'products'));
    })->name('view-seller.show');

    //Rute softpay
    Route::middleware(['auth'])->group(function () {
        Route::get('/softpay', [SoftPayController::class, 'index'])->name('softpay-customer');
        Route::get('/softpay/topup', function() { return view('view-customer.softpay.topup'); })->name('softpay.topup');
        Route::get('/softpay/withdraw', function() { return view('view-customer.softpay.withdraw'); })->name('softpay.withdraw');
        Route::get('/softpay/pay', function() { return view('view-customer.softpay.pay'); })->name('softpay.pay');
        Route::get('/softpay/transfer', function() { return view('view-customer.softpay.transfer'); })->name('softpay.transfer');
        Route::get('/softpay/history', function() { return view('view-customer.softpay.history'); })->name('softpay.history');
        Route::get('/softpay/promo', function() { return view('view-customer.softpay.promo'); })->name('softpay.promo');
        Route::get('/softpay/help', function() { return view('view-customer.softpay.help'); })->name('softpay.help');
    });
});

// Admin routes
Route::get('/register-admin', function () {
    return view('view-admin/register-admin');
})->name('register-admin');
Route::get('/chart-admin', function () {
    return view('view-admin/chart-admin');
})->name('chart-admin');
Route::get('/faq-admin', function () {
    return view('view-admin/faq-admin');
})->name('faq-admin');

Route::middleware(['auth', UpdateLastSeen::class, TrackPageView::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/customer/produks', [ProductController::class, 'index'])->name('customer.produk');
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

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
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

// Admin chat routes (VIEW-BASED, jika ada)
Route::middleware('auth')->group(function () {
    Route::get('/admin/chat/users', [ChatController::class, 'getChatUsersForAdminPage'])->name('admin.chat.users'); // Contoh: jika ini mengembalikan view
    Route::get('/admin/chat/messages/{id}', [ChatController::class, 'fetchMessagesWithUserPage'])->name('admin.chat.messages'); // Contoh: jika ini mengembalikan view
    Route::post('/admin/chat/send/{id}', [ChatController::class, 'sendMessageToUserPost'])->name('admin.chat.send'); // Contoh: jika ini memproses form dan redirect
    Route::get('/chat/admin/messages', [ChatController::class, 'fetchMessagesWithAdminPage'])->name('customer.chat.messages'); // Contoh: jika ini mengembalikan view
    Route::post('/chat/admin/send', [ChatController::class, 'sendMessageToAdminPost'])->name('customer.chat.send'); // Contoh: jika ini memproses form dan redirect
});