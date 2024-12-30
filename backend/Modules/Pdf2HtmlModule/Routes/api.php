<?php

use Illuminate\Support\Facades\Route;
use Modules\Pdf2HtmlModule\Controllers\TransformController;

Route::group(['prefix' => 'pdf2-html'], function() {
    Route::post('/{resource_id}', [TransformController::class, 'transform']);
});
