<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
/**
 * Middleware to check for a Sanctum authentication token in the session.
 *
 * This middleware verifies if a valid login token exists in the session 
 * before allowing the request to proceed. If the token is missing, 
 * it redirects the user to the login page.
 */
class CheckLoginToken
{
    /**
     * Handle an incoming request and check for a login token in the session.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @param \Closure $next The next middleware to call.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse Redirects to login view if token is missing, otherwise proceeds with the request.
     */
    public function handle(Request $request, Closure $next): Response | RedirectResponse | BinaryFileResponse
    {
        if (!$request->session()->has('logintoken')) {
            return response()->view('login');
        }

        return $next($request);
    }
}