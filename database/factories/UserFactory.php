<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'profile_banner_url' => 'https://picsum.photos/800',
            'bio' => Str::limit(fake()->paragraph(random_int(1, 3)), 279, '') . '.',
            'link_url' => 'https://manmachineltd.com',
            'link_text' => 'ManMachine',
            'location' => fake()->city() . ', ' . fake()->country(),
            'handle' => fake()->unique()->username(),
            'email' => fake()->unique()->safeEmail(),
            'avatar_url' => "https://i.pravatar.cc/150?img=" . random_int(1, 70),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
