<?php
  
namespace App\Http\Services;
use Illuminate\Http\JsonResponse;

/**
 * Service for managing standardized JSON responses.
 *
 * Provides methods to send success and error responses with a consistent structure,
 * making API responses more manageable and readable.
 */
class ResponseService
{
    /**
     * Sends a successful JSON response.
     *
     * This method constructs a standardized JSON response for successful requests,
     * including a success message and additional data.
     *
     * @param string $message The message to be returned in the response.
     * @param array $result Additional data to include in the response.
     * @return \Illuminate\Http\JsonResponse JSON response with HTTP status 200.
     */
    public function sendResponse(string $message, array $result): JsonResponse
    {
        return $this->sendStandardResponse($message, $result, 200);
    }
  
    /**
     * Sends an error JSON response.
     *
     * Constructs a standardized JSON response for errors, with a custom message,
     * optional error details, and a configurable status code.
     *
     * @param string $error The error message to include in the response.
     * @param array $errorMessages Optional additional error details.
     * @param int $code HTTP status code, defaulting to 404.
     * @return \Illuminate\Http\JsonResponse JSON response with the specified error status.
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 404): JsonResponse
    {       
        return $this->sendStandardResponse($error, $errorMessages, $code);
    }

    /**
     * Constructs and sends a standardized JSON response.
     *
     * This private method standardizes the JSON response structure used for both
     * success and error responses, including a success indicator, message, data,
     * and the specified HTTP status code.
     *
     * @param string $message The primary message of the response.
     * @param array $result The data or error details to include.
     * @param int $code The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse JSON response with the given message and status code.
     */
    private function sendStandardResponse(string $message, array $result, int $code): JsonResponse
    {
        $response = [
            'success' => ($code === 200),
            'message' => $message,
            'data' => $result ?? [],
        ];

        return response()->json($response, $code);
    }
}