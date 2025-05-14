<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GajiKaryawanController;

Route::get('/karyawan', [GajiKaryawanController::class, 'index']); // Menampilkan data
