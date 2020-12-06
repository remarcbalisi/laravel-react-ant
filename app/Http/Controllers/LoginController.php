<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\RequestTokenResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $token = auth()->user()->createToken('Access Token ' . date("h:i:sa"))->accessToken;;
            return new RequestTokenResource( (object) ['token' => $token, 'email' => auth()->user()->email]);
        }
        abort(401);
    }
}
