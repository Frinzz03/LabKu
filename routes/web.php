<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PeminjamanLabController;
use App\Http\Controllers\AdminPeminjamanController;

// Pastikan user login dulu (middleware auth)
// Route::middleware(['auth'])->group(function () {
    // Menampilkan form peminjaman
    Route::get('/peminjaman-lab/create', [PeminjamanLabController::class, 'create'])->name('peminjaman.create');
    
    // Memproses data form (Logika yang sudah kita buat)
    Route::post('/peminjaman-lab', [PeminjamanLabController::class, 'store'])->name('peminjaman.store');
// });
    Route::get('/peminjaman-lab/check-availability', [PeminjamanLabController::class, 'checkAvailability'])
        ->name('peminjaman.check-availability');

// Halaman List Peminjaman
    Route::get('/admin-peminjaman-lab', [AdminPeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    
    // Action Approve
    Route::post('/admin-peminjaman-lab/{id}/approve', [AdminPeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
    
    // Action Reject
    Route::post('/admin-peminjaman-lab/{id}/reject', [AdminPeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');