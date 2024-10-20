<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Logout in Frontend
     *
     * @return \Illuminate\Http\RedirectResponse | bool;
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->guard('web')->logout();
        return redirect()->route('/');
    }
    
    /**
     * Login with API-call
     *
     * @return \Illuminate\Http\RedirectResponse | bool;
     */
    public function login(Request $request)
    {
        $response = HTTP::timeout(60)->post(env('API_URL') . '/login', 
        ['email' => $request->email,
                'password' => $request->password]);
        $data = $response->json('data')??[];
        array_push($data, $response->json('message'));
        if(true !== $response->json('success')) return back()->withErrors($data);
        $user = User::where('email', $request->email)->first();
        if($user){
            Auth::login($user);
        }
        session(['sanctum_token' => $data['token']]);
        return back();
    }
}