<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Services\ContactCSVHandlerService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class APICSVImportController extends Controller
{
    protected $responseService;
    protected $contactCSVHandlerService;
    public function __construct(ResponseService $responseService, ContactCSVHandlerService $contactCSVHandlerService)
    {
        $this->contactCSVHandlerService = $contactCSVHandlerService;
        $this->responseService = $responseService;
    }

    /** 
     * upload CSV
     * 
     * @param Request $request;
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
    */
    public function upload(Request $request): Response | JsonResponse {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
        if(($e = $this->contactCSVHandlerService->upload($request)) instanceof \Exception )    
            return $this->responseService->sendError('Error importing CSV: ' . $e->getMessage());
        return $this->responseService->sendResponse('CSV imported successfully.',[]);
    }   
}
