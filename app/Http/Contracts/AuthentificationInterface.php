<?php
namespace App\Http\Contracts;
use Illuminate\Http\Request;
Interface AuthentificationInterface {
    public function login(Request $request): array | bool;
    public function logout(Request $request):bool;
}