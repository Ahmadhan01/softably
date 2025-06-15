<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-admin', function () {
    return view('dashboard-admin');
});

Route::get('/login-admin', function () {
    return view('/login-admin');
});