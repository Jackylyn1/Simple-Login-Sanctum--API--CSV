<?php
namespace App\Http\Contracts;
use Illuminate\Http\Request;

Interface FileHandlerInterface {
    public function upload(Request $request): bool | \Exception;
}