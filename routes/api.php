<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->middleware([ValidateToken::class])->group(function () {
    Route::prefix('/user')->as('user:')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/order', [UserController::class, 'order'])->name('order');
        Route::post('/withdraw', [UserController::class, 'withdraw'])->name('withdraw');
        Route::post('/deposit', [UserController::class, 'deposit'])->name('deposit');
    });
});