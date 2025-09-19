<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ApprovalController;

Route::get('/', function () {
    return redirect()->route('surat-masuk.index');
});

// Semua rute aplikasi memerlukan login
Route::middleware(['auth'])->group(function () {

    // Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::post('surat-masuk/{surat_masuk}/disposisi', [SuratMasukController::class, 'kirimDisposisi'])
        ->name('surat-masuk.disposisi');

    // Disposisi inbox & update status
    Route::get('disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
    Route::post('disposisi/{disposisi}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.update-status');

    // Surat Keluar
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::post('surat-keluar/{surat_keluar}/submit', [SuratKeluarController::class, 'submit'])->name('surat-keluar.submit');

    // Approval (Kajur/Kepsek)
    Route::post('surat-keluar/{surat_keluar}/approve', [ApprovalController::class, 'approve'])->name('surat-keluar.approve');
    Route::post('surat-keluar/{surat_keluar}/reject',  [ApprovalController::class, 'reject'])->name('surat-keluar.reject');
});

Route::middleware(['auth','role:kepala_jurusan'])->post(
  'surat-keluar/{surat_keluar}/approve-kajur',
  [ApprovalController::class, 'approveKajur']
)->name('surat-keluar.approve-kajur');

Route::middleware(['auth','role:kepala_sekolah'])->post(
  'surat-keluar/{surat_keluar}/approve-kepsek',
  [ApprovalController::class, 'approveKepsek']
)->name('surat-keluar.approve-kepsek');

// Alias 'dashboard' ke halaman utama aplikasi
Route::get('/dashboard', function () {
    return redirect()->route('surat-masuk.index');
})->middleware(['auth'])->name('dashboard');

Route::post('/surat-masuk/{surat_masuk}/disposisi', [\App\Http\Controllers\SuratMasukController::class, 'kirimDisposisi'])
    ->name('surat-masuk.kirim-disposisi')
    ->middleware(['auth','permission:surat-masuk.update']);

Route::middleware(['auth','role:TU'])->group(function () {
    Route::post('/surat-masuk/{surat_masuk}/disposisi', [SuratMasukController::class, 'kirimDisposisi'])
        ->name('surat-masuk.kirim-disposisi');
});

// routes/web.php
Route::post('/surat-masuk/{surat_masuk}/disposisi',
    [\App\Http\Controllers\SuratMasukController::class, 'kirimDisposisi']
)->name('surat-masuk.kirim-disposisi')
 ->middleware(['auth','role:TU']);

// Pastikan rute autentikasi Breeze aktif
require __DIR__.'/auth.php';
