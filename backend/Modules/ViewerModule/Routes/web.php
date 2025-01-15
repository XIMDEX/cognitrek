<?php

use Illuminate\Support\Facades\Route;
use Modules\ViewerModule\Controllers\ViewerController;

// Web routes for the viewer module
Route::group(['prefix' => 'viewer'], function() {
    Route::get('/{resource_id}', [ViewerController::class, 'view'])->name('viewerModule.view_resource');
});
