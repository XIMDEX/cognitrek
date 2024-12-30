<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'example'], function() {
    Route::get('/', function() {
        return response('Home Example Module');
    });
});
