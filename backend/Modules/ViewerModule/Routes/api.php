<?php

use Illuminate\Support\Facades\Route;
use Modules\ViewerModule\Controllers\ViewerController;

Route::group(['prefix' => 'viewer'], function() {
    Route::get('/health', function() {
        return response()->json(['status' => 'ok']);
    });
    Route::get('/{resource_id}', [ViewerController::class, 'view'])->name('viewer.view');
});
