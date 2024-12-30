<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LLMController;
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

    Route::group(['prefix' => 'auth'], function() {
        Route::post('login',        [AuthController::class, 'login'])->name('v1.auth.login');
        Route::post('signup',       [AuthController::class, 'signup'])->name('v1.auth.signup');
    });

    Route::group(['prefix' => 'llm', 'middleware' => 'AuthMiddleware'], function() {
        Route::post('/{resource_id}/resume',    [LLMController::class, 'generateResume'])->name('llm.resource.generate_resume');
        Route::post('/{resource_id}/map',       [LLMController::class, 'generateMentalmap'])->name('llm.generate_mentalmap');
        Route::post('/{resource_id}/variant',   [LLMController::class, 'generateVariant'])->name('llm.generate_variant');


        Route::get('/{resource_id}/resume',    [LLMController::class, 'getResume'])->name('llm.resource.get_resume');
        Route::get('/{resource_id}/map',       [LLMController::class, 'getMentalmap'])->name('llm.get_mentalmap');
        Route::get('/{resource_id}/variant',   [LLMController::class, 'getVariant'])->name('llm.get_variant');

    });
});
