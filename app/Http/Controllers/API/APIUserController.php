<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseService;
class APIUserController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService){
        $this->responseService = $responseService;
    }
    
    /**
     * get User connected to the active token
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function getLoggedInUser(Request $request): Response | JsonResponse 
    {
        $personalAccessToken = $this->getPersonalToken($request);
        if ($personalAccessToken) {
            $user = $personalAccessToken->tokenable();
            return $this->sendResponse('User is authenticated', [$user]);
        }
        return $this->sendError(error: 'Unauthenticated', code: 401);
    }
}
