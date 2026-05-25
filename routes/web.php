<?php

use Illuminate\Support\Facades\Route;

// 1. Halaman utama (bisa diarahkan ke Dashboard atau langsung ke Users)
Route::get('/', function () {
    return view('users'); // ganti ke 'dashboard' jika ada halaman dashboard
});

// 2. Route Halaman Users
Route::get('/users', function () {
    return view('users'); // Membuka file resources/views/users.blade.php
})->name('users.page');

// 3. Route Halaman Customers
Route::get('/customers-ui', function () {
    return view('customers'); // Membuka file resources/views/customers.blade.php
})->name('customers.page');

Route::get('/services', function () {
    return view('services');
})->name('services.page');

// 5. Route Halaman Subscription
Route::get('/subscriptions', function () {
    return view('subscriptions'); // Membuka file resources/views/subscriptions.blade.php
})->name('subscriptions.page');