<?php

use App\Http\Controllers\NowShowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:now'])
    ->get('/v1/now', NowShowController::class)
    ->name('now.show');
