<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

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
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'handle' => 'required|string|max:255|unique:users,handle',
                'email' => 'required|email|max:255|unique:users,email|exists:approved_emails,email',
                'password' => [
                    'required',
                    'string',
                    'max:255',
                    'confirmed',
                    Password::min(12)
                ],
                'device_name' => 'required|string|max:255',
            ],
            [
                'email.exists' => 'The email address is not on the approved list and cannot be used to register an account.  Please try another email address or contact your account administrator.',
            ]
        );

        $user = User::create($validated);

        $user->following()->attach($user->id);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Return the successfully authenticated user.
     */
    public function authUser(Request $request)
    {
        return $request->user();
    }

    /**
     * Display tweets by users that the auth user follows.
     */
    public function followedTweets()
    {
        $following = Auth::user()->following->pluck('id');

        return Tweet::with('user:id,name,handle,avatar_url')->whereIn('user_id', $following)->latest()->paginate(10);
    }

    /**
     * Return users the auth user is following.
     */
    public function following()
    {
        return Auth::user()->following;
    }

    /**
     * Returns users that are following the auth user.
     */
    public function followers()
    {
        return Auth::user()->followers;
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
