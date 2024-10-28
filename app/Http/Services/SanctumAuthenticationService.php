<?php
namespace App\Http\Services;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\AuthentificationInterface;

/**
 * Service for handling authentication using Laravel Sanctum.
 *
 * Implements user login, logout, and session management functionalities based on Sanctum tokens.
 */
class SanctumAuthenticationService implements AuthentificationInterface
{
    /**
     * Retrieve the personal access token from the request.
     *
     * Extracts and returns the Sanctum personal access token based on the Authorization header.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the access token.
     * @return PersonalAccessToken|null The found token, or null if not present.
     */
    protected function getPersonalToken(Request $request): PersonalAccessToken | null {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        return PersonalAccessToken::findToken($token);
    }

    /**
     * Retrieve the user associated with the active access token.
     *
     * Finds the user connected to the provided access token in the request.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the access token.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|bool The user model if authenticated, or false if not.
     */
    public function getLoggedInUser(Request $request): \Illuminate\Database\Eloquent\Relations\MorphTo | bool
    {
        $personalAccessToken = $this->getPersonalToken($request);
        return $personalAccessToken ? $personalAccessToken->tokenable() : false;
    }

    /**
     * Log in a user and generate a Sanctum token.
     *
     * Validates credentials and, on success, returns an array with the user's name and a new access token.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing login credentials.
     * @return array|bool The array containing 'name' and 'token' on success, or false on failure.
     */
    public function login(Request $request): array | bool
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return [
                'token' => $user->createToken('apiToken')->plainTextToken,
                'name' => $user->name,
            ];
        }
        return false;
    }

    /**
     * Log out a user by invalidating the Sanctum token.
     *
     * Deletes the access token associated with the request, effectively logging the user out.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the access token.
     * @return bool True on successful logout, false if no token was found.
     */
    public function logout(Request $request): bool
    {
        $tokenModel = $this->getPersonalToken($request);
        if ($tokenModel) {
            $tokenModel->delete();
            return true;
        }
        return false;
    }
}