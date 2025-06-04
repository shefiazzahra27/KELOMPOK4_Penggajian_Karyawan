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
Route::apiResource('penggajians', PenggajianController::class);
