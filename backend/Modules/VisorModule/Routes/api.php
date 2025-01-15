<?php

use Illuminate\Support\Facades\Route;
use Modules\VisorModule\Controllers\VisorController;

Route::group(['prefix' => 'visor'], function() {
    Route::get('/health', function() {
        return response()->json(['status' => 'ok']);
    });
    Route::get('/{resource_id}', [VisorController::class, 'view'])->name('visor.view');
});
