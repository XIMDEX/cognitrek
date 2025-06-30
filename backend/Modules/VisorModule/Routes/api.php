<?php

use Illuminate\Support\Facades\Route;
use Modules\VisorModule\Controllers\VisorController;

Route::group(['prefix' => 'visor'], function() {
    Route::get('/health', function() {
        return response()->json(['status' => 'ok']);
    });
    Route::get('/{resource_id}/preview', [VisorController::class, 'preview'])->name('visor.preview');
    Route::get('/{resource_id}', [VisorController::class, 'visor'])->name('visor.visor');
});
