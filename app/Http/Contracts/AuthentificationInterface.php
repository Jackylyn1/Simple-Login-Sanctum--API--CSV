<?php
namespace App\Http\Contracts;
use Illuminate\Http\Request;

/**
 * Interface for user authentication and session management.
 *
 * Defines methods for logging users in and out of the system,
 * handling authentication states and managing session data.
 *
 * @see \App\Services\SessionAuthenticationService For an implementation example.
 */
interface AuthentificationInterface
{
    /**
     * Authenticate and log a user into the system.
     *
     * Verifies the provided user credentials from the request, and upon success,
     * initiates a session for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request The request containing user credentials.
     * @return bool|array True if the login was successful, or an array of user data if additional details are returned.
     */
    public function login(Request $request): array|bool;

    /**
     * Terminate an active user session and log the user out.
     *
     * Ends the authenticated session for the user identified by the request data.
     *
     * @param \Illuminate\Http\Request $request The request containing the user’s session data.
     * @return bool True if the logout was successful, false if no active session was found.
     */
    public function logout(Request $request): bool;
}
