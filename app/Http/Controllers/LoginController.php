<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Services\SessionAuthenticationService;

class LoginController extends Controller
{
    protected $sessionAuthenticationService;

    public function __construct(SessionAuthenticationService $sessionAuthenticationService){
        $this->sessionAuthenticationService = $sessionAuthenticationService;
    }
    /**
     * Logout in Frontend
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function logout(Request $request)
    {
        $response = HTTP::withToken(session('logintoken'))->timeout(60)->post(env('API_URL') . '/logout', 
        []);
        $this->sessionAuthenticationService->logout($request);
        return redirect('/')->with('message', $response->json('message')??'');
    }
    
    /**
     * Login with API-call
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function login(Request $request)
    {
        $response = HTTP::timeout(60)->post(env('API_URL') . '/login', 
        ['email' => $request->email,
                'password' => $request->password]);
        if(true !== $response->json('success')) return back()->withErrors([$response->json('message')]);
        $request->token = $response->json('data');
        $this->sessionAuthenticationService->login($request);
        return back()->with('message', $response->json('message')??'');
    }
}