<?php
namespace App\Http\Services;
use App\Http\Contracts\AuthentificationInterface;
use Illuminate\Http\Request;

/**
 * Service for handling session-based authentication.
 *
 * Provides methods for logging users in and out using session data.
 */
class SessionAuthenticationService implements AuthentificationInterface
{
    /**
     * Log in a user by storing the authentication token in the session.
     *
     * Saves the token in the session to maintain user authentication state.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing user data, including the token.
     * @return bool True if the token is successfully stored in the session; otherwise, false.
     */
    public function login(Request $request): bool
    {
        session(['logintoken' => $request->data['token']]);
        return session()->has('logintoken');
    }

    /**
     * Log out a user by clearing the session data and regenerating the CSRF token.
     *
     * Invalidates and regenerates the session to fully log out the user and remove all session data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request associated with the current session.
     * @return bool True when the session is successfully invalidated and the user is logged out.
     */
    public function logout(Request $request): bool
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->guard('web')->logout();
        return true;
    }
}