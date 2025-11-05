<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tweet::with('user:id,name,handle,avatar_url')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(1);

        $validated = $request->validate(['body' => ['required', 'string', 'max:280']]);

        $tweet = Tweet::create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);
        $tweet->save();

        return $tweet;
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        return $tweet;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $user = $tweet->user;

        $validated = $request->validate(['body' => ['required', 'string', 'max:280']]);

        $tweet->update([
            'body' => $validated['body'],
        ]);
        $tweet->save();

        return $tweet;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return response()->noContent();
    }
}
