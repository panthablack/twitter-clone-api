<?php

namespace Database\Seeders;

use App\Helpers\EmailHelpers;
use App\Models\ApprovedEmail;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DEFAULT_ADMIN_NAME = env('DEFAULT_ADMIN_NAME');
        $DEFAULT_ADMIN_EMAIL = env('DEFAULT_ADMIN_EMAIL');
        $DEFAULT_ADMIN_HANDLE = env('DEFAULT_ADMIN_HANDLE');
        $DEFAULT_ADMIN_PASSWORD = env('DEFAULT_ADMIN_PASSWORD');
        $DEFAULT_ADMIN_AVATAR_URL = env('DEFAULT_ADMIN_AVATAR_URL');

        if ($DEFAULT_ADMIN_EMAIL && $DEFAULT_ADMIN_PASSWORD) {
            ApprovedEmail::factory()->create([
                'email' => $DEFAULT_ADMIN_EMAIL,
            ]);

            $user = User::factory()->create([
                'name' => $DEFAULT_ADMIN_NAME ?? fake()->name(),
                'email' => $DEFAULT_ADMIN_EMAIL,
                'handle' => $DEFAULT_ADMIN_HANDLE ?? EmailHelpers::getEmailUsername($DEFAULT_ADMIN_EMAIL),
                'password' => Hash::make($DEFAULT_ADMIN_PASSWORD),
                'avatar_url' => $DEFAULT_ADMIN_AVATAR_URL ?? null,
            ]);

            Tweet::factory(10)->create(['user_id' => $user->id]);
        }
    }
}
