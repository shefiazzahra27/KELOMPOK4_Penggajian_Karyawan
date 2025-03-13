<?php

use App\Http\Controllers\PenggajianController;

// Routes manual
Route::get('/penggajians', [PenggajianController::class, 'index']); // Menampilkan semua data
Route::post('/penggajians', [PenggajianController::class, 'store']); // Menyimpan data baru
Route::get('/penggajians/{id}', [PenggajianController::class, 'show']); // Menampilkan data berdasarkan ID
Route::put('/penggajians/{id}', [PenggajianController::class, 'update']); // Mengupdate data berdasarkan ID
Route::delete('/penggajians/{id}', [PenggajianController::class, 'destroy']); // Menghapus data berdasarkan ID