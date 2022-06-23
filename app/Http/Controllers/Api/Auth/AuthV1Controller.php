<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthV1Controller extends Controller
{
    use Helpers;

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            return $this->response->errorUnauthorized();
        }

        $user = User::where('email', $validatedData['email'])->firstOrFail();
        $token = $user->createToken('app_API')->plainTextToken;

        return $this->response->array([
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_api')->plainTextToken;

        return $this->response->array([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
