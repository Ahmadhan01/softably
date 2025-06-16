<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('view-admin/login-admin');
});

Route::get('/dashboard-admin', function () {
    return view('view-admin/dashboard-admin');
});

Route::get('/register-admin', function () {
    return view('view-admin/register-admin');
});

Route::get('/chart-admin', function () {
    return view('view-admin/chart-admin');
});

Route::get('/faq-admin', function () {
    return view('view-admin/faq-admin');
});

//routers customer
Route::get('/produk-customer', function () {    
    return view('view-customer/produk-customer');
});

Route::get('/cart-customer', function () {    
    return view('view-customer/cart-customer');
}); 

Route::get('/chat-customer', function () {    
    return view('view-customer/chat-customer');
}); 

Route::get('/checkout-customer', function () {    
    return view('view-customer/checkout-customer');
}); 

Route::get('/detailorder-customer', function () {    
    return view('view-customer/detailorder-customer');
}); 

Route::get('/bantuan-customer', function () {    
    return view('view-customer/bantuan-customer');
}); 

Route::get('/landingpage-customer', function () {    
    return view('view-customer/landingpage-customer');
}); 

Route::get('/notif-customer', function () {    
    return view('view-customer/notif-customer');
}); 

Route::get('/order-customer', function () {    
    return view('view-customer/order-customer');
}); 

Route::get('/setting-customer', function () {    
    return view('view-customer/setting-customer');
}); 

Route::get('/viewproduk-customer', function () {    
    return view('view-customer/viewproduk-customer');
}); 

Route::get('/whislist-customer', function () {    
    return view('view-customer/whislist-customer');
}); 