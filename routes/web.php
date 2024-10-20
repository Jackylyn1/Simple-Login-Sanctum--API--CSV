<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::check()) return view('welcome');
    return view('login');
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('login','login')->name('login');
});
