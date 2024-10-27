<?php
namespace App\Http\Services;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
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