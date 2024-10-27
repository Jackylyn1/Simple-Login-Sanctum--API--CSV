<?php
  
namespace App\Http\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
  
class ResponseService
{
    /**
     * Get Access-Token
     *
     * @param  \Illuminate\Http\Request
     * @return PersonalAccessToken | null
     */
    protected function getPersonalToken(Request $request): PersonalAccessToken | null {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        return PersonalAccessToken::findToken($token);
    }
    
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