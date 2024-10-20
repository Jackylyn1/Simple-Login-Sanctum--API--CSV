<?php
  
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;
  
class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse(string $message, array $result): JsonResponse
    {
        return $this->sendStandardResponse($message, $result, 200);
    }
  
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError (string $error, array $errorMessages = [], $code = 404):JsonResponse
    {       
        return $this->sendStandardResponse($error, $errorMessages, $code);
    }

    /**
     * return standard response.
     *
     * @return \Illuminate\Http\Response
     */
    private function sendStandardResponse(string $message, array $result, int $code):JsonResponse
    {
        $response = [
            'success' => (($code == 200)?true:false),
            'message' => $message,
        ];
        $response['data'] = $result??[];  
        return response()->json($response, $code);
    }
}