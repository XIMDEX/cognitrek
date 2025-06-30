<?php

use Illuminate\Support\Facades\Route;
use Modules\VisorModule\Controllers\VisorController;

// Web routes for the visor module
Route::group(['prefix' => 'visor'], function() {
    Route::get('/{resource_id}', [VisorController::class, 'view'])->name('visorModule.view_resource');
});
