<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Controller for handling CSV import functionalities.
 *
 * This controller provides methods for loading the CSV import form and 
 * uploading CSV files to the server. It utilizes the HTTP client to 
 * send the uploaded CSV file to an external API for processing.
 */
class CSVImportController extends Controller
{
    /** 
     * Load the CSV import form view.
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * The view instance of the CSV import form.
     */
    public function loadForm(): \Illuminate\Contracts\View\View | \Illuminate\Contracts\View\Factory {
        return view('csvimport');
    }

    /** 
     * Upload a CSV file to the external API.
     * 
     * This method processes the incoming request to retrieve the CSV file 
     * and sends it to the designated API endpoint. It handles the file upload
     * and returns the user back to the previous page with a message indicating
     * the result of the upload operation.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the CSV file.
     * @return \Illuminate\Http\RedirectResponse Redirect response back to the previous page.
     */
    public function upload(Request $request): \Illuminate\Http\RedirectResponse {
        $response = HTTP::withToken(session('logintoken'))
            ->attach(
                'csv_file', file_get_contents($request->file('csv_file')->getRealPath()), basename($request->file('csv_file')->getClientOriginalName())
            )
            ->timeout(60)
            ->post(env('API_URL') . '/upload-csv', [
            ]);
        return back()->with('message', $response->json('message') ?? '');
    }   
}