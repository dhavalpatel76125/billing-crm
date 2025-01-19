<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CustomerController;

// Public routes (without middleware)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

// Protected routes (with middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Invoice routes
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', 'App\Http\Controllers\InvoiceController@index')->name('index');
        Route::get('/create', 'App\Http\Controllers\InvoiceController@create')->name('create');
        Route::post('/store', 'App\Http\Controllers\InvoiceController@store')->name('store');
        Route::get('/edit/{id}', 'App\Http\Controllers\InvoiceController@edit')->name('edit');
        Route::put('/update/{id}', 'App\Http\Controllers\InvoiceController@update')->name('update');
        Route::delete('/delete/{id}', 'App\Http\Controllers\InvoiceController@delete')->name('delete');
        Route::get('/show/{id}', 'App\Http\Controllers\InvoiceController@show')->name('show');
    });

    // Customer routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', 'App\Http\Controllers\CustomerController@index')->name('index');
        Route::get('/create', 'App\Http\Controllers\CustomerController@create')->name('create');
        Route::post('/store', 'App\Http\Controllers\CustomerController@store')->name('store');
        Route::get('/edit/{id}', 'App\Http\Controllers\CustomerController@edit')->name('edit');
        Route::post('/update/{id}', 'App\Http\Controllers\CustomerController@update')->name('update');
        Route::delete('/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->name('delete');
        Route::get('/show/{id}', 'App\Http\Controllers\CustomerController@show')->name('show');
        Route::get('/transactions/{id}', 'App\Http\Controllers\CustomerController@transactions')->name('transactions');
        Route::get('/balance-sheet', [CustomerController::class, 'showBalanceSheet'])->name('balance_sheet');
    });

    // Product routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', 'App\Http\Controllers\ProductController@index')->name('index');
        Route::get('/create', 'App\Http\Controllers\ProductController@create')->name('create');
        Route::post('/store', 'App\Http\Controllers\ProductController@store')->name('store');
        Route::get('/edit/{id}', 'App\Http\Controllers\ProductController@edit')->name('edit');
        Route::post('/update/{id}', 'App\Http\Controllers\ProductController@update')->name('update');
        Route::delete('/delete/{id}', 'App\Http\Controllers\ProductController@delete')->name('delete');
        Route::get('/show/{id}', 'App\Http\Controllers\ProductController@show')->name('show');
    });
});
