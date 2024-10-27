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
}