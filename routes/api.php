<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

    Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.auth.logout');
    Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/auth/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh'])->name('api.auth.refresh');


    Route::apiResource('/car',App\Http\Controllers\Api\CarController::class, ['as' => 'api']);
    Route::delete('/car/{car}/delete', [App\Http\Controllers\Api\CarController::class, 'delete'])->name('api.car.delete');
    Route::post('/car/{car}/restore', [App\Http\Controllers\Api\CarController::class, 'restore'])->name('api.car.restore');

    Route::apiResource('/motorcycle',App\Http\Controllers\Api\MotorcycleController::class, ['as' => 'api']);
    Route::delete('/motorcycle/{motorcycle}/delete', [App\Http\Controllers\Api\MotorcycleController::class, 'delete'])->name('api.motorcycle.delete');
    Route::post('/motorcycle/{motorcycle}/restore', [App\Http\Controllers\Api\MotorcycleController::class, 'restore'])->name('api.motorcycle.restore');

    Route::apiResource('/vechile',App\Http\Controllers\Api\VechileController::class, ['as' => 'api']);
    Route::delete('/vechile/{vechile}/delete', [App\Http\Controllers\Api\VechileController::class, 'delete'])->name('api.vechile.delete');
    Route::post('/vechile/{vechile}/restore', [App\Http\Controllers\Api\VechileController::class, 'restore'])->name('api.vechile.restore');


    Route::get('/sale', [App\Http\Controllers\Api\SaleController::class, 'index'])->name('api.sale.index');
    Route::get('/sale/statistic', [App\Http\Controllers\Api\SaleController::class, 'statistic'])->name('api.sale.statistic');

});
