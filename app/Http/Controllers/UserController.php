<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return Tweet::with('user:id,name,handle,avatar_url')->where('user_id', '=',  $user->id)->latest()->paginate(10);
    }

    /**
     * Display tweets by users that the auth user follows.
     */
    public function followedTweets(User $user)
    {
        $following = $user->following->pluck('id');

        return Tweet::with('user:id,name,handle,avatar_url')->whereIn('user_id', $following)->latest()->paginate(10);
    }

    /**
     * Return users the auth user is following.
     */
    public function follow(User $user)
    {
        return $user->follow();
    }

    /**
     * Return users the auth user is following.
     */
    public function unfollow(User $user)
    {
        return $user->unfollow();
    }

    /**
     * Return users the auth user is following.
     */
    public function following(User $user)
    {
        return $user->following;
    }

    /**
     * Returns users that are following the auth user.
     */
    public function followers(User $user)
    {
        return $user->followers;
    }

    /**
     * Returns users that are following the auth user.
     */
    public function followedByAuthUser(User $user)
    {
        return ['followed' => $user->isFollowedByAuthUser()];
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
