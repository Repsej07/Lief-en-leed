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
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => $dateOfBirth->format('Y-m-d'),
            'date_of_employment' => $dateOfEmployment->format('Y-m-d'),
            'end_of_employment' => $endOfEmployment,
            'date_of_retirement' => $dateOfRetirement->format('Y-m-d'),
            'date_of_marriage' => $dateOfMarriage,
            'date_of_death' => $dateOfDeath,
            'remember_token' => Str::random(10),
            'afdeling' => $this->faker->randomElement($afdelingen),
            'is_sick' => $this->faker->boolean(20),
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
