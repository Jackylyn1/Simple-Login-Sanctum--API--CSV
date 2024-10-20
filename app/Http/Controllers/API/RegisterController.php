<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
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
            $userdata['Token'] = $user->createToken('MyApp')->plainTextToken;
            $userdata['name'] = $user->name;
            return $this->sendResponse($user->name . ' logged in successfully.', $userdata);
        }
        return $this->sendError('Wrong userdata');
    }
}
