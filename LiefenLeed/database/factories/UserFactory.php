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
        $now = new \DateTime();
        $dateOfBirth = fake()->dateTimeBetween('-100 year', '-18 years');
        $employmentStart = (clone $dateOfBirth)->modify('+18 years');

        // Avoid future employment start
        if ($employmentStart > $now) {
            $employmentStart = (clone $now)->modify('-1 day');
        }

        $dateOfEmployment = fake()->dateTimeBetween($employmentStart, $now);
        $dateOfRetirement = (clone $dateOfBirth)->modify('+65 years');

        $retirementCap = fake()->boolean(10)
            ? $dateOfRetirement
            : (clone $dateOfEmployment)->modify('+1 year');



        return [
            'Medewerker' => fake()->numberBetween(0, 999999),
            'Roepnaam' => fake()->firstName(),
            'Voorvoegsel' => fake()->optional()->word(),
            'Achternaam' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'Geboortedatum' => $dateOfBirth->format('Y-m-d'),
            'In_dienst_ivm_dienstjaren' => $dateOfEmployment->format('Y-m-d'),
            'AOW-datum' => $dateOfRetirement->format('Y-m-d'),
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
