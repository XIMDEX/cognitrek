<?php

use Illuminate\Support\Facades\Route;
use Modules\Pdf2HtmlModule\Controllers\ConversionController;

Route::group(['prefix' => 'pdf2-html'], function() {
    Route::get('/{resource_id}', [ConversionController::class, 'conversion']);
});
