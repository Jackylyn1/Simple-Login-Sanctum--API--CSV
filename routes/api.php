<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiRegisterController;
use \Illuminate\Routing\Middleware\SubstituteBindings;

Route::controller(ApiRegisterController::class)->middleware(['auth:sanctum', 'throttle:15,5', SubstituteBindings::class])->group(function(){
    Route::post('logout','logout');
});

Route::controller(ApiRegisterController::class)->group(function(){
    Route::post('login','login')->middleware('throttle:15,5');
});