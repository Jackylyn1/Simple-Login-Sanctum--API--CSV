<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware(['web'])->get('/', function () {
    if(Auth::check()) return view('welcome');
    return view('login');
})->name('/');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout', [RegisterController::class, 'logout'])->name('logout');
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('login','login')->name('login');
    Route::get('login',function(){
        return redirect()->route('/');
    })->name('login');
});
