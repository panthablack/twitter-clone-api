<?php

namespace Database\Seeders;

use App\Models\ApprovedEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovedEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TEST_APPROVED_EMAIL = env('TEST_APPROVED_EMAIL');

        if ($TEST_APPROVED_EMAIL) ApprovedEmail::factory()->create([
            'email' => $TEST_APPROVED_EMAIL,
        ]);
    }
}
