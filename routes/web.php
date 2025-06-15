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