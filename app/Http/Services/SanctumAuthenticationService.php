<?php
namespace App\Http\Services;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SanctumAuthenticationService {

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
     * get User connected to the active token
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo | bool
     */
    public function getLoggedInUser(Request $request): \Illuminate\Database\Eloquent\Relations\MorphTo | bool
    {
        $personalAccessToken = $this->getPersonalToken($request);
        if ($personalAccessToken) {
            $user = $personalAccessToken->tokenable();
            return $user;
        }
        return false;
    }

     /**
     * Login with SanctumToken
     *
     * @param  \Illuminate\Http\Request
     * @return array | bool
     */
    public function login(Request $request): array | bool
    {
        if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])){
            $user = Auth::user();
            $userdata['token'] = $user->createToken('apiToken')->plainTextToken;
            $userdata['name'] = $user->name;
            return $userdata;
        }
        return false;
    }


    /**
     * Logout from Sanctum
     *
     * @param  \Illuminate\Http\Request
     * @return bool
     */
    public function logout(Request $request): bool
    {
        $tokenModel = $this->getPersonalToken($request);
        if($tokenModel = $this->getPersonalToken($request)){
            $tokenModel->delete();
            return true;
        } 
        return false;
    }
}