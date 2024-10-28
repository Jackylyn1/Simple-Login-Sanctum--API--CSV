<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseService;
use App\Http\Services\SanctumAuthenticationService;

/**
 * Controller for handling API login and logout functionalities.
 * 
 * This controller provides endpoints for logging in and logging out users via the API.
 * It relies on `SanctumAuthenticationService` for handling authentication and 
 * `ResponseService` for standardized JSON responses.
 */
class ApiLoginController extends Controller
{
    /**
     * Service for managing and standardizing JSON responses.
     * 
     * @var \App\Http\Services\ResponseService
     */
    protected $responseService;

    /**
     * Service for handling Sanctum-based authentication processes.
     * 
     * @var \App\Http\Services\SanctumAuthenticationService
     */
    protected $sanctumAuthenticationService;

    /**
     * Initialize ApiLoginController with required services.
     *
     * @param \App\Http\Services\ResponseService $responseService Service for standardized responses.
     * @param \App\Http\Services\SanctumAuthenticationService $sanctumAuthenticationService Service for managing authentication with Sanctum.
     */
    public function __construct(ResponseService $responseService, SanctumAuthenticationService $sanctumAuthenticationService)
    {
        $this->responseService = $responseService;
        $this->sanctumAuthenticationService = $sanctumAuthenticationService;
    }

    /**
     * Log out a user from the API.
     *
     * Checks for a valid personal access token in the request and, if found,
     * logs the user out. Returns a standardized JSON response.
     *
     * @param  \Illuminate\Http\Request $request The HTTP request instance containing the token.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$this->sanctumAuthenticationService->getPersonalToken($request)) {
            return $this->responseService->sendError('Token not found');
        }
        
        return $this->responseService->sendResponse('You logged out successfully.', []);
    }

    /**
     * Log in a user to the API.
     *
     * Validates the request data, including email and password. If validation passes
     * and credentials are correct, returns a JSON response with the user details.
     * Otherwise, returns an error response.
     *
     * @param  \Illuminate\Http\Request $request The HTTP request containing login credentials.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success with user data, or failure.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation failed', $validator->errors()->toArray());
        }

        if ($user = $this->sanctumAuthenticationService->login($request)) {
            return $this->responseService->sendResponse($user['name'] . ' logged in successfully.', $user);
        }

        return $this->responseService->sendError('Incorrect credentials');
    }
}