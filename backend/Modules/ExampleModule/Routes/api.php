<?php

use Illuminate\Support\Facades\Route;
use Modules\ExampleModule\Controllers\ExampleController;

Route::group(['prefix' => 'example'],

 function() {
    Route::get('/health', function() {
        return response()->json([
            'status' => 'OK',
            'name' => config('ExampleModule.name'),
            'verions' => config('ExampleModule.version')
        ]);
    });

    Route::get('/',    [ExampleController::class, 'index'])->name('ExampleModule.index');
});
