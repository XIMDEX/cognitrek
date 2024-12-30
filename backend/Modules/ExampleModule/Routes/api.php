<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'example'], function() {
    Route::get('/', function() {
        return response()->json([
            'status' => 'OK',
            'name' => config('ExampleModule.name'),
            'verions' => config('ExampleModule.version')
        ]);
    });
});
