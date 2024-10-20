<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Login with API-call
     *
     * @return \Illuminate\Http\RedirectResponse | bool;
     */
    public function login(Request $request)
    {
        $response = HTTP::timeout(120)->post(env('API_URL') . '/login', 
        ['email' => $request->email,
                'password' => $request->password]);
        $status = $response->json('success');
        $message = $response->json('message');
        $data = $response->json('data');
        if($status !== true) return back()->withErrors(array_push($data, $message));
        session(['sanctum_token' => $data['token']]);
        return redirect()->back();
    }
}