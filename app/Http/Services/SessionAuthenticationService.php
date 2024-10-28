<?php
namespace App\Http\Services;
use App\Http\Contracts\AuthentificationInterface;
use Illuminate\Http\Request;

class SessionAuthenticationService implements AuthentificationInterface {

    /**
     * Login with Session
     *
     * @param  array $content
     * @return bool
     */
    public function login(Request $request): bool
    {
        session('logintoken', $request->token);
        return true;
    }

    /**
     * Logout from Session, including deletion of all data
     *
     * @param  \Illuminate\Http\Request
     * @return bool
     */
    public function logout(Request $request):bool {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->guard('web')->logout();
        return true;
    }
}