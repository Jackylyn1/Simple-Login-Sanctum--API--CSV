<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Services\SessionAuthenticationService;
/**
 * Controller for managing user login and logout functionalities.
 */
class LoginController extends Controller
{
    /**
     * Service for handling session-based authentication processes.
     * 
     * @var \App\Http\Services\SessionAuthenticationService
     */
    protected $sessionAuthenticationService;

    /**
     * Initialize the LoginController with required services.
     *
     * @param \App\Http\Services\SessionAuthenticationService $sessionAuthenticationService
     */
    public function __construct(SessionAuthenticationService $sessionAuthenticationService){
        $this->sessionAuthenticationService = $sessionAuthenticationService;
    }

    /**
     * Log out the user from the frontend.
     *
     * Sends a logout request to the external API and clears the session on the server.
     *
     * @param \Illuminate\Http\Request $request The incoming request instance.
     * @return \Illuminate\Http\RedirectResponse Redirects to the homepage with a logout message.
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = HTTP::withToken(session('logintoken'))
            ->timeout(60)
            ->post(env('API_URL') . '/logout', []);
        $this->sessionAuthenticationService->logout($request);

        return redirect('/')->with('message', $response->json('message') ?? '');
    }

    /**
     * Log in the user via an API call.
     *
     * Validates the user's credentials, sends a login request to the external API, 
     * and stores session data if successful.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing login credentials.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a login success message or error.
     */
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = HTTP::timeout(60)->post(env('API_URL') . '/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (true !== $response->json('success')) {
            return back()->withErrors([$response->json('message')]);
        }

        $request->data = $response->json('data');
        $this->sessionAuthenticationService->login($request);

        return back()->with('message', $response->json('message') ?? '');
    }
}
