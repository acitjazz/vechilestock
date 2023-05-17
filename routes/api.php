<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    Route::get('/car', [App\Http\Controllers\Api\CarController::class, 'index']);
    Route::get('/car/{type}', [App\Http\Controllers\Api\CarController::class, 'index']);

    Route::get('/motorcycle', [App\Http\Controllers\Api\MotorcycleController::class, 'index']);
    Route::get('/motorcycle/{slug}', [App\Http\Controllers\Api\MotorcycleController::class, 'show']);

    Route::get('/vechile', [App\Http\Controllers\Api\VechileController::class, 'index']);
    Route::get('/vechile/{slug}', [App\Http\Controllers\Api\VechileController::class, 'show']);

});
