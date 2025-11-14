<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'handle',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'following', 'follower_id', 'followed_user_id')->withTimestamps();
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'following', 'followed_user_id', 'follower_id',)->withTimestamps();
    }

    public function follow(User $user): void
    {
        $this->following()->attach($user);
    }

    public function unfollow(User $user): void
    {
        $this->following()->detach($user);
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('id', $user->id)->exists();
    }

    public function isFollowedBy(User $user): bool
    {
        return $user->followers()->where('id', Auth::user()->id)->exists();
    }
}
