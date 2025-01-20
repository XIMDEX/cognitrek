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

    // Route::group(['prefix' => 'auth'], function() {
    //     Route::post('login',        [AuthController::class, 'login'])->name('v1.auth.login');
    //     Route::post('signup',       [AuthController::class, 'signup'])->name('v1.auth.signup');
    // });

    Route::group(['prefix' => 'llm', 'middleware' => 'AuthMiddleware'], function() {
        // Route::post('/{resource_id}/resume',    [LLMController::class, 'generateResume'])->name('llm.resource.generate_resume');
        // Route::post('/{resource_id}/map',       [LLMController::class, 'generateMentalmap'])->name('llm.generate_mentalmap');
        // Route::post('/{resource_id}/variant',   [LLMController::class, 'generateVariant'])->name('llm.generate_variant');


        // Route::get('/{resource_id}/resume',    [LLMController::class, 'getResume'])->name('llm.resource.get_resume');
        // Route::get('/{resource_id}/map',       [LLMController::class, 'getMentalmap'])->name('llm.get_mentalmap');
        // Route::get('/{resource_id}/variant',   [LLMController::class, 'getVariant'])->name('llm.get_variant');

    });

    Route::group(['prefix' => 'resource/{resouce_id}'], function() {
        Route::get('/',[ResourceController::class, 'show'])->name('resouce.show');
        Route::post('resource/{resouce_id}', [ResourceController::class, 'store'])->name('resouce.store');
        Route::put('resource/{resouce_id}', [ResourceController::class, 'update'])->name('resouce.update');
        Route::delete('resource/{resouce_id}', [ResourceController::class, 'destroy'])->name('resouce.destroy');
        
        Route::get('/summary',[ResourceController::class, 'resume'])->name('resouce.resume');
        Route::post('/summary',[ResourceController::class, 'regenerate_resume'])->name('resouce.regenerate_resume');


        Route::get('/conceptual_map',[ResourceController::class, 'conceptualmap'])->name('resouce.conceptualmap');
        Route::post('/conceptual_map',[ResourceController::class, 'regenerate_conceptualmap'])->name('resouce.regenerate_conceptualmap');

        Route::get('/variants', [VariantController::class, 'getResourceVariants'])->name('resource.variants');
    });


    Route::group(['prefix' => 'variant'], function() {
        //! change index in GET
        Route::get('/', [VariantController::class, 'store'])->name('variant.list');
        Route::get('/{variant_id}', [VariantController::class, 'show'])->name('variant.show');
        Route::post('/', [VariantController::class, 'store'])->name('variant.store');
        Route::put('/{variant_id}', [VariantController::class, 'update'])->name('variant.update');
        Route::delete('/{variant_id}', [VariantController::class, 'destroy'])->name('variant.destroy');
    });

    Route::group(['prefix' => 'condition'], function() {
        Route::get('/', [ConditionController::class, 'index'])->name('condition.list');
        Route::get('/{condition_id}', [ConditionController::class, 'show'])->name('condition.show');
        Route::post('/', [ConditionController::class, 'store'])->name('condition.store');
        Route::put('/{condition_id}', [ConditionController::class, 'update'])->name('condition.update');
        Route::delete('/{condition_id}', [ConditionController::class, 'destroy'])->name('condition.destroy');
    });



});
