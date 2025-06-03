<?php

use App\Http\Controllers\API\KaryawanController;
use App\Http\Controllers\API\GajiKaryawanController;
use App\Http\Controllers\Api\AbsensiKaryawanController;
use App\Http\Controllers\Api\AuthController;

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Definisikan route API untuk resource Penggajian
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/create', [KaryawanController::class, 'create']);
    Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'delete']);
    Route::put('/karyawan/update/{id}', [KaryawanController::class, 'update']);

    Route::get('/karyawan/gaji', [GajiKaryawanController::class, 'index']);
    Route::post('/karyawan/gaji/create', [GajiKaryawanController::class, 'create']);
    Route::put('/karyawan/gaji/update/{id_karyawan}', [GajiKaryawanController::class, 'update']);
    Route::delete('/karyawan/gaji/delete/{id_karyawan}', [GajiKaryawanController::class, 'delete']);

    Route::get('/karyawan/absensi', [AbsensiKaryawanController::class, 'index']);
    Route::post('/karyawan/absensi/create', [AbsensiKaryawanController::class, 'create']);
    Route::put('/karyawan/absensi/{id}/update', [AbsensiKaryawanController::class, 'update']);
    Route::delete('/karyawan/absensi/{id}/delete', [AbsensiKaryawanController::class, 'delete']);
});
