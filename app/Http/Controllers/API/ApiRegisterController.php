<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiRegisterController extends Controller
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

    /**
     * Logout in Backend
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $tokenModel = PersonalAccessToken::findToken($token);

        if(empty($tokenModel)) $this->sendError('Token not found');
        $tokenModel->delete();
        return $this->sendResponse('You logged out successfully.', []);
    }

    /**
     * Login API
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email'
        ]);
        
        if($validator->fails()){
            return $this->sendError('validation faied', $validator->errors()->toArray());
        }

        if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])){
            $user = Auth::user();
            $userdata['token'] = $user->createToken('apiToken')->plainTextToken;
            $userdata['name'] = $user->name;
            return $this->sendResponse($user->name . ' logged in successfully.', $userdata);
        }
        return $this->sendError('Wrong userdata');
    }
}
