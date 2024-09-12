<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\ProfileController;

Route::redirect('/', '/home');

Auth::routes(['register' => true]);



Route::resource('prediksi', PrediksiController::class);
Route::resource('profile', ProfileController::class);
Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::resource('penjualan', PenjualanController::class);
Route::post('/import/barang', [BarangController::class, 'import'])->name('import-brg');
Route::post('/import/penjualan', [PenjualanController::class, 'import'])->name('import-pjl');
Route::get('penjualan/{id}/edit', [PenjualanController::class, 'edit'])->name('Penjualan.edit');
Route::put('penjualan/{id}', [PenjualanController::class, 'update'])->name('Penjualan.update');
Route::resource('barang', BarangController::class);
Route::get('/upload/barang', [BarangController::class, 'create'])->name('upload-brg');
Route::get('/upload/penjualan', [PenjualanController::class, 'create'])->name('upload-pjl');
Route::get('barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('barang/{id}', [BarangController::class, 'update'])->name('barang.update');

Route::post('/result', [PrediksiController::class, 'forecast'])->name('forecast-real');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
