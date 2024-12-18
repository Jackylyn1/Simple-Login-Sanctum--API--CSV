<?php

use App\Http\Controllers\API\APICSVImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiLoginController;
use \Illuminate\Routing\Middleware\SubstituteBindings;

Route::middleware(['auth:sanctum', 'throttle:15,5', SubstituteBindings::class])->group(function(){
    Route::controller(ApiLoginController::class)->group(function(){
        Route::post('logout','logout');
    });
    Route::controller(APICSVImportController::class)->group(function(){
        Route::post('upload-csv', 'upload');
    });
});

Route::controller(ApiLoginController::class)->group(function(){
    Route::post('login','login')->middleware('throttle:15,5');
});