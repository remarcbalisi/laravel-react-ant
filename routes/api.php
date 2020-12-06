<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/user/login', LoginController::class)->name('user.login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/auth/user', AuthController::class);
});

Route::name('admin.')->prefix('admin')->group(function () {

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::apiResource('user', UserController::class);
    });
});
