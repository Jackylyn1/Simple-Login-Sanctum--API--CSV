<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /**
     * Logout in Frontend
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function logout(Request $request)
    {
        $response = HTTP::withToken(session('sanctum_token'))->timeout(60)->post(env('API_URL') . '/logout', 
        []);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->guard('web')->logout();
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
        session(['sanctum_token' => $response->json('data')['token']]);
        return back()->with('message', $response->json('message')??'');
    }
}