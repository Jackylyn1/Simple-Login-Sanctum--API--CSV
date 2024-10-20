<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiRegisterController;
use \Illuminate\Routing\Middleware\SubstituteBindings;

Route::middleware(['auth:sanctum', 'throttle:15,5', SubstituteBindings::class])->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::controller(ApiRegisterController::class)->group(function(){
    Route::post('login','login')->middleware('throttle:15,5');
});