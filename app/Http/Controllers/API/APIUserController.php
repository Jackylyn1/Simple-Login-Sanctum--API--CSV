<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class APIUserController extends BaseController
{
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
