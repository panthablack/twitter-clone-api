<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'James Randall',
            'handle' => 'panthablack',
            'password' => Hash::make('secret'),
            'avatar_url' => 'https://gravatar.com/avatar/cd9c87e383e8da9189663cbb5fa0bb5008a870792e21d7d723da67c4a9c2e731?v=1498007925000&size=256&d=initials',
            'email' => 'panthablack@hotmail.com',
        ]);

        Tweet::factory(10)->create(['user_id' => $user->id]);

        $this->call(TweetSeeder::class);
    }
}
