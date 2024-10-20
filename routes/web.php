<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $token = session('sanctum_token');
    if(!empty($token)) return view('welcome');
    return view('login');
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('login','login')->name('login');
});
