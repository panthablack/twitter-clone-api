<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        foreach ($users as $user) {
            // set following
            $user->follows()->syncWithoutDetaching(fake()->randomElements(range(1, 20), random_int(1, 10)));

            // create some tweets
            Tweet::factory(random_int(1, 10))->create([
                'user_id' => $user->id
            ]);
        }
    }
}
