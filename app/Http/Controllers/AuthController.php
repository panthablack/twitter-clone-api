<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Log in user by generating a token.
     */
    public function logIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'device_name' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password))
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'handle' => 'required|string|max:255|unique:users,handle',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|string|max:255',
            'device_name' => 'required|string|max:255',
        ]);

        return User::create($validated);
    }

    /**
     * Return the successfully authenticated user.
     */
    public function authUser(Request $request)
    {
        return $request->user();
    }

    /**
     * Log out the authenticated user by deleting all their tokens.
     */
    public function logOut(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->noContent();
    }
}
