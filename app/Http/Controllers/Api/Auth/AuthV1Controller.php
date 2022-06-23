<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();

        return $this->response->array([
            'message' => 'Logout successful',
        ]);
    }
}
