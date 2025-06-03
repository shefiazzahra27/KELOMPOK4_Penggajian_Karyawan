<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GajiKaryawanController;

Route::get('/', function () {
    abort(403);
});
