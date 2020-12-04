<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\RequestTokenResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $token = auth()->user()->createToken('token-name')->accessToken;;
            return new RequestTokenResource( (object) ['token' => $token, 'email' => auth()->user()->email]);
        }
        abort(401);
    }
}
