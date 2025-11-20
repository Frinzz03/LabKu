<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('peminjaman_barang.view');
});
