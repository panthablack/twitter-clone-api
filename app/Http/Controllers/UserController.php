<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(403, 'Forbidden');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403, 'Forbidden');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Display the user's tweets.
     */
    public function tweets(User $user)
    {
        return Tweet::with('user:id,name,handle,avatar_url')->where('user_id', '=',  $user->id)->paginate(10);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(403, 'Forbidden');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(403, 'Forbidden');
    }
}
