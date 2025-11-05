<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'avatar_url' => 'https://gravatar.com/panthablack',
            'email' => 'panthablack@hotmail.com',
        ]);

        Tweet::factory(10)->create(['user_id' => $user->id]);

        $this->call(TweetSeeder::class);
    }
}
