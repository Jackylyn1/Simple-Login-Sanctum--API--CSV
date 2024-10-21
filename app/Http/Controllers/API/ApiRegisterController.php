<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Response;
use Validator;
use Illuminate\Http\JsonResponse;

class ApiRegisterController extends BaseController
{

    /**
     * Logout in Backend
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse | Response
    {
        $tokenModel = $this->getPersonalToken($request);
        if(empty($tokenModel)) $this->sendError('Token not found');
        $tokenModel->delete();
        return $this->sendResponse('You logged out successfully.', []);
    }

    /**
     * Login API
     *
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse | Response
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email'
        ]);
        
        if($validator->fails()){
            return $this->sendError('validation failed', $validator->errors()->toArray());
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
