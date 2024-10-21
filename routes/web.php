<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['check.sanctum.token'])->group(function(){
    Route::controller(RegisterController::class)->group(function(){
        Route::get('logout', 'logout')->name('logout');
    });
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('login','login')->name('login');
    Route::get('login',function(){
        return redirect()->route('/');
    })->name('login');
});
