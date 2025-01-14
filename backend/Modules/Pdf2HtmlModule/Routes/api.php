<?php

use Illuminate\Support\Facades\Route;
use Modules\Pdf2HtmlModule\Controllers\TransformController;

Route::group(['prefix' => 'pdf2-html'], function() {
    Route::get('/{resource_id}', [TransformController::class, 'transform']);
});
