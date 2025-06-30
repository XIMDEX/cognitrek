<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthXdirModule\Controllers\XAuthController;
use Modules\AuthXdirModule\Controllers\XRegisterController;

// API routes for the auth-xdir module
Route::group(['prefix' => 'xauth'], function() {

    Route::post('register', [XRegisterController::class, 'store'])->name('xauth.register');
    Route::post('login', [XAuthController::class, 'login'])->name('xauth.login');

    Route::post('logout', [XAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

    Route::post('refresh', [XAuthController::class, 'refresh'])->name('xauth.refresh');
    Route::get('me', [XAuthController::class, 'whoami'])->name('xauth.me');
});
