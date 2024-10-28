<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
class CheckSanctumToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next):  Response | RedirectResponse
    {
        if (!$request->session()->has('logintoken'))
            return response()->view('login');
        return $next($request);
    }
}
