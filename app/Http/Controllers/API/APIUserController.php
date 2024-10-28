<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseService;
use App\Http\Services\SanctumAuthenticationService;

/**
 * Controller for retrieving information about the authenticated API user.
 *
 * This controller provides an endpoint to retrieve details about the user 
 * associated with the current access token. It leverages `SanctumAuthenticationService`
 * for token-based user retrieval and `ResponseService` for JSON response formatting.
 *
 * @package App\Http\Controllers
 */
class APIUserController extends Controller
{
    /**
     * Service for formatting and managing JSON responses.
     * 
     * @var \App\Http\Services\ResponseService
     */
    protected ResponseService $responseService;

    /**
     * Service for managing user authentication and retrieving user data based on Sanctum tokens.
     * 
     * @var \App\Http\Services\SanctumAuthenticationService
     */
    protected SanctumAuthenticationService $sanctumAuthenticationService;

    /**
     * Initializes an instance of APIUserController with required services.
     *
     * Injects `ResponseService` and `SanctumAuthenticationService` to handle 
     * JSON responses and user authentication, respectively.
     *
     * @param \App\Http\Services\ResponseService $responseService Service for standardized responses.
     * @param \App\Http\Services\SanctumAuthenticationService $sanctumAuthenticationService Service for managing authentication.
     */
    public function __construct(ResponseService $responseService, SanctumAuthenticationService $sanctumAuthenticationService)
    {
        $this->responseService = $responseService;
        $this->sanctumAuthenticationService = $sanctumAuthenticationService;
    }

    /**
     * Retrieve the authenticated user based on the active token.
     *
     * This method verifies the presence of a valid access token in the request and
     * returns the associated user information. If the user is authenticated, 
     * returns a JSON response containing user data. Otherwise, responds with an 
     * error indicating that the user is unauthenticated.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the access token.
     * @return \Illuminate\Http\JsonResponse JSON response with user data on success or an error message on failure.
     */
    public function getLoggedInUser(Request $request): JsonResponse
    {
        if ($user = $this->sanctumAuthenticationService->getLoggedInUser($request)) {
            return $this->responseService->sendResponse('User is authenticated', [$user]);
        }

        return $this->responseService->sendError('Unauthenticated', code: 401);
    }
}