<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVImportController;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;



Route::get('/', function () {
    return view('login');
})->name('/');

Route::controller(LoginController::class)->group(function(){
    Route::post('login','login')->name('login');
    Route::get('login',function(){
        return redirect()->route('/');
    })->name('login');
});

Route::middleware(['check.sanctum.token'])->group(function(){
    Route::controller(LoginController::class)->group(function(){
        Route::get('logout', 'logout')->name('logout');
    });
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::controller(CSVImportController::class)->group(function(){
        Route::get('import-csv', 'loadForm')->name('import.csv.form');
        Route::post('import-csv','upload')->name('import.csv.upload');
    });

    Route::get('/documentation/{path?}', function ($path = null): BinaryFileResponse {
        $fullPath = storage_path('phpdocs/' . $path);
        $headers = [];
        if (str_ends_with($path, '.css')) {
            $headers['Content-Type'] = 'text/css';
        }
        
        if (!$path || !File::exists($fullPath)) {
            $fullPath = storage_path('phpdocs/index.html');
        }
        return response()->file($fullPath, $headers);
    })->where('path', '.*')->name('documentation');
});
