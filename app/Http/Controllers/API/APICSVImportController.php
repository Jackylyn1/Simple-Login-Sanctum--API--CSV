<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Services\ContactCSVHandlerService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Controller for handling CSV imports via API.
 *
 * This controller provides functionality to upload and process CSV files, 
 * and sends responses indicating the success or failure of the operations.
 */
class APICSVImportController extends Controller
{
    /**
     * Handles standardized JSON responses.
     *
     * @var ResponseService
     */
    protected ResponseService $responseService;

    /**
     * Handles CSV file processing and import logic.
     *
     * @var ContactCSVHandlerService
     */
    protected ContactCSVHandlerService $contactCSVHandlerService;

    /**
     * Constructor for APICSVImportController.
     *
     * Injects necessary services for handling responses and processing CSV files.
     *
     * @param \App\Http\Services\ResponseService $responseService Service for creating standard responses.
     * @param \App\Http\Services\ContactCSVHandlerService $contactCSVHandlerService Service for handling CSV file uploads and processing.
     */
    public function __construct(ResponseService $responseService, ContactCSVHandlerService $contactCSVHandlerService)
    {
        $this->contactCSVHandlerService = $contactCSVHandlerService;
        $this->responseService = $responseService;
    }

    /**
     * Upload and import CSV file.
     *
     * Validates the incoming request for a CSV file and attempts to upload it. If successful, 
     * returns a success response; if an error occurs during the import, returns an error response.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the CSV file.
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse JSON response indicating success or failure of the import.
     */
    public function upload(Request $request): Response | JsonResponse
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if (($e = $this->contactCSVHandlerService->upload($request)) instanceof \Exception) {
            return $this->responseService->sendError('Error importing CSV: ' . $e->getMessage());
        }
        
        return $this->responseService->sendResponse('CSV imported successfully.', []);
    }   
}