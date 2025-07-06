<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\TransactionController;



use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController; // Pastikan ini di-import
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SellerNotificationController;
use App\Http\Controllers\SoftPayController;
use App\Http\Controllers\HomeController;



use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Middleware\TrackPageView;
use App\Http\Middleware\LogVisitTest;
use App\Http\Controllers\LinkController;
use App\Models\Link;

use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerSoftpayController;


Route::get('/', function () {
    return view('landing-page');
});

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






// Seller
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', fn() => view('view-seller.dashboard-seller'))->name('seller.dashboard');

    Route::get('/chat-seller', [ChatController::class, 'sellerChat'])->name('chat.seller');

    Route::get('/bantuan-seller', function () {
        $loggedInUser = Auth::user();
        return view('view-seller/bantuan-seller', compact('loggedInUser'));
    })->name('bantuan-seller');

    // Rute untuk daftar produk seller
    Route::get('/seller/products', [SellerProductController::class, 'index'])->name('seller.products.index');
    // Rute untuk menampilkan form tambah produk
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    // Rute untuk menyimpan produk baru (method POST)   
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('seller.products.store');

    Route::get('/seller/products/{product}/details', [SellerProductController::class, 'show'])->name('seller.products.details');

    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    // Rute untuk memperbarui produk (method PUT/PATCH)
    Route::put('/seller/products/{product}', [SellerProductController::class, 'update'])->name('seller.products.update');

    Route::get('/notif-seller', [SellerNotificationController::class, 'index'])->name('notif-seller');
    Route::post('/notif-seller/mark-all-as-read', [SellerNotificationController::class, 'markAllAsRead'])->name('notif-seller.markAllAsRead');
    Route::post('/notif-seller/{notification}/mark-as-read', [SellerNotificationController::class, 'markAsRead'])->name('notif-seller.markAsRead');

    Route::get('/seller/softpay', [SellerSoftpayController::class, 'index'])->name('seller.softpay.dashboard');
    Route::get('/seller/softpay/history', [SellerSoftpayController::class, 'history'])->name('seller.softpay.history');
    Route::get('/seller/softpay/withdraw', [SellerSoftpayController::class, 'showWithdrawForm'])->name('seller.softpay.withdraw');
    Route::post('/seller/softpay/withdraw', [SellerSoftpayController::class, 'processWithdraw'])->name('seller.softpay.processWithdraw');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/chat/messages/{conversation}', [ChatController::class, 'getMessages'])->name('chat.getMessages');
    Route::post('/chat/send/{conversation}', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/chat/create-or-get-conversation', [ChatController::class, 'createOrGetConversation'])->name('chat.createOrGetConversation');
});


Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply'); // Rute untuk membalas komentar
    Route::post('/comments/{product}', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update'); 
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


// Customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Route::get('/customer/produks', [ProductController::class, 'index'])->name('customer.produk');

    Route::get('/view-product/{product}', function (Product $product) {
        // UBAH INI: Eager load 'user' (bukan 'seller')
        $product->load([
            'user', // <-- PENTING: Gunakan 'user' sesuai nama relasi di Product.php
            'comments' => function ($query) {
                $query->whereNull('parent_id') // Tetap filter top-level di sini
                      ->with(['user', 'replies.user']);
            }
        ]);
        return view('view-customer.viewproduk-customer', compact('product'));
    })->name('view-product.show');      
    
    //rute wishlist
    Route::get('/wishlist-customer', [WishlistController::class, 'index'])->name('wishlist-customer.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store'); // Untuk menambah
    Route::delete('/wishlist/{product_id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy'); // Untuk menghapus
    
    // Rute Cart
    Route::get('/cart-customer', [CartController::class, 'index'])->name('cart-customer.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/multiple', [CartController::class, 'destroyMultiple'])->name('cart.destroy.multiple');
    
    // UBAH BARIS INI: dari CartController::class, 'processCheckout' ke CartController::class, 'processToCheckout'
    Route::post('/cart/process-to-checkout', [CartController::class, 'processToCheckout'])->name('cart.processToCheckout');


    // Rute Checkout (method GET untuk menampilkan, method POST untuk memproses pembelian)
    Route::get('/checkout-customer', [CheckoutController::class, 'index'])->name('checkout-customer.index');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process'); // Ini method POST untuk menyelesaikan pembelian
    Route::post('/prepare-checkout', [CartController::class, 'prepareCheckout'])->name('prepare.checkout');
    Route::post('/checkout/softpay', [CheckoutController::class, 'processSoftPayPayment'])->name('checkout.softpay'); // <--- TAMBAHKAN INI

    // Rute Notifikasi (Hanya satu definisi ini yang benar)
    Route::get('/notif-customer', [NotificationController::class, 'index'])->name('notif-customer');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead'); // Opsional

    Route::post('/clear-checkout-session', function (Illuminate\Http\Request $request) {
    $request->session()->forget('selected_cart_items_for_checkout');
    return response()->json(['message' => 'Checkout session cleared.']);
    })->name('clear.checkout.session');

    // Rute CHAT BARU
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
        $products = $user->products()->get(); // Memuat produk milik seller
        return view('view-customer.seller-profile', compact('user', 'products'));
    })->name('view-seller.show');

    //Rute softpay
    Route::middleware(['auth'])->group(function () {
    Route::get('/softpay', [SoftPayController::class, 'index'])->name('softpay-customer');
    Route::get('/softpay/topup', function() { return view('view-customer.softpay.topup'); })->name('softpay.topup'); // Contoh halaman terpisah
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
    Route::get('/seller/dashboard', fn() => view('view-seller.dashboard-seller'))->name('seller.dashboard');
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

// Ambil daftar customer yang pernah kirim chat
Route::get('/admin/chat/customers', [ChatController::class, 'getCustomerListForAdmin'])->middleware('auth');

// Ambil isi chat antara admin dan 1 customer tertentu
Route::get('/admin/chat/customer/{id}', [ChatController::class, 'viewChatWithCustomer'])->middleware('auth');

Route::get('/admin/chat/customers', [ChatController::class, 'getCustomerListForAdmin']);
Route::get('/admin/chat/messages/{id}', [ChatController::class, 'fetchMessagesWithCustomer']);
Route::post('/admin/chat/send/{id}', [ChatController::class, 'sendMessageToCustomer']);


Route::middleware('auth')->group(function () {
    Route::get('/chat/admin/messages', [ChatController::class, 'fetchMessagesWithAdmin']);
    Route::post('/chat/admin/send', [ChatController::class, 'sendMessageToAdmin']);
});


// *** Rute API untuk Info Seller ***
Route::get('/api/seller-info/{user}', function (User $user) {
    if ($user->role !== 'seller') {
        return response()->json(['success' => false, 'message' => 'User bukan seller.'], 404);
    }

    // HAPUS LOGIKA PENGHITUNGAN TRANSAKSI
    // $successTransactions = 0;
    // $failedTransactions = 0;
    // $user->load('products.transactions');
    // foreach ($user->products as $product) {
    //     if ($product->transactions) {
    //         foreach ($product->transactions as $transaction) {
    //             if (in_array($transaction->status, ['completed', 'success'])) {
    //                 $successTransactions++;
    //             } elseif (in_array($transaction->status, ['failed', 'cancelled'])) {
    //                 $failedTransactions++;
    //             }
    //         }
    //     }
    // }

    return response()->json([
        'success' => true,
        'user' => [ // Kunci ini tetap 'user' agar sesuai dengan pemanggilan di JS
            'id' => $user->id,
            'name' => $user->name,
            'profile_picture_url' => $user->profile_picture_url,
            'is_online' => $user->isOnline(),
            'description' => $user->store_description,
        ],
        // HAPUS data transaksi dari respons
        // 'success_transactions' => $successTransactions,
        // 'failed_transactions' => $failedTransactions,
    ]);
})->name('api.seller.info');