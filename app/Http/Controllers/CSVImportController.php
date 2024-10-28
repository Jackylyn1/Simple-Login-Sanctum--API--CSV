<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class CSVImportController extends Controller
{
    /** 
     * Load CSV-Form
     *  
     * @return \Illuminate\Contracts\View\View | \Illuminate\Contracts\View\Factory
    */
    public function loadForm(): \Illuminate\Contracts\View\View | \Illuminate\Contracts\View\Factory {
        return view('csvimport');
    }

    /** 
     * upload CSV
     * 
     * @param Request $request;
     * @return \Illuminate\Http\RedirectResponse;
    */
    public function upload(Request $request){
        $response = HTTP::withToken(session('logintoken'))
        ->attach(
            'csv_file', file_get_contents($request->file('csv_file')->getRealPath()), basename($request->file('csv_file')->getClientOriginalName())
        )
        ->timeout(60)
        ->post(env('API_URL') . '/upload-csv', [
        ]);
        return back()->with('message', $response->json('message')??'');
    }   
}
