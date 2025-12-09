<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [UserController::class, 'index'])->name('Dashboard');

// Route Untuk Barang
Route::resource('barang', BarangController::class);
