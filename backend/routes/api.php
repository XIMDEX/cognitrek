<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\LLMController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\VariantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/health', function() {
    return response()->json(['status' => 'OK']);
})->name('api.v1.status_health');

Route::group(['prefix' => 'v1', 'as' => 'v.'], function() {
    Route::get('/health', function() {
        return response()->json(['status' => 'OK']);
    })->name('api.v1.status_health');


    Route::group(['prefix' => 'resources/{resouce_id}'], function() {
        Route::get('/',[ResourceController::class, 'show'])->name('resouce.show');
        Route::post('/', [ResourceController::class, 'store'])->name('resouce.store');
        Route::put('/', [ResourceController::class, 'update'])->name('resouce.update');
        Route::delete('/', [ResourceController::class, 'destroy'])->name('resouce.destroy');

        Route::get('/summary',[ResourceController::class, 'resume'])->name('resouce.resume');
        Route::post('/summary',[ResourceController::class, 'regenerate_resume'])->name('resouce.regenerate_resume');


        Route::get('/conceptual_map',[ResourceController::class, 'conceptualmap'])->name('resouce.conceptualmap');
        Route::post('/conceptual_map',[ResourceController::class, 'regenerate_conceptualmap'])->name('resouce.regenerate_conceptualmap');

        Route::get('/variants', [VariantController::class, 'getResourceVariants'])->name('resource.variants');
    });


    Route::group(['prefix' => 'variants'], function() {
        //! change index in GET
        Route::get('/', [VariantController::class, 'store'])->name('variant.list');
        Route::get('/{variant_id}', [VariantController::class, 'show'])->name('variant.show');
        Route::post('/', [VariantController::class, 'store'])->name('variant.store');
        Route::put('/{variant_id}', [VariantController::class, 'update'])->name('variant.update');
        Route::delete('/{variant_id}', [VariantController::class, 'destroy'])->name('variant.destroy');
    });

    Route::group(['prefix' => 'conditions'], function() {
        Route::get('/', [ConditionController::class, 'index'])->name('condition.list');
        Route::get('/{condition_id}', [ConditionController::class, 'show'])->name('condition.show');
        Route::post('/', [ConditionController::class, 'store'])->name('condition.store');
        Route::put('/{condition_id}', [ConditionController::class, 'update'])->name('condition.update');
        Route::delete('/{condition_id}', [ConditionController::class, 'destroy'])->name('condition.destroy');
    });
});
