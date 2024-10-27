<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseService;
use App\Http\Services\SanctumAuthenticationService;
class APIUserController extends Controller
{
    protected $responseService;
    protected $sanctumAuthenticationService;

    public function __construct(ResponseService $responseService, SanctumAuthenticationService $sanctumAuthenticationService){
        $this->responseService = $responseService;
        $this->sanctumAuthenticationService = $sanctumAuthenticationService;
    }

    /**
     * get User connected to the active token
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function getLoggedInUser(Request $request): Response | JsonResponse 
    {
        $personalAccessToken = $this->sanctumAuthenticationService->getPersonalToken($request);
        if ($personalAccessToken) {
            $user = $personalAccessToken->tokenable();
            return $this->responseService->sendResponse('User is authenticated', [$user]);
        }
        return $this->responseService->sendError(error: 'Unauthenticated', code: 401);
    }
}
