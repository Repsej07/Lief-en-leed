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

        $endOfEmployment = null;
        if (fake()->boolean(10) && $dateOfEmployment < $retirementCap) {
            $endOfEmployment = fake()->dateTimeBetween($dateOfEmployment, $retirementCap)->format('Y-m-d');
        } elseif ($endOfEmployment === null && $now >= $dateOfRetirement) {
            $endOfEmployment = $dateOfRetirement->format('Y-m-d');
        }

        $marriageStart = (clone $dateOfBirth)->modify('+18 years');
        $marriageEnd = $marriageStart > $now ? $marriageStart : $now;
        $dateOfMarriage = $marriageStart < $marriageEnd
            ? fake()->dateTimeBetween($marriageStart, $marriageEnd)->format('Y-m-d')
            : $marriageStart->format('Y-m-d');

        $dateOfDeath = fake()->boolean(10)
            ? fake()->dateTimeBetween($retirementCap, (clone $retirementCap)->modify('+20 years'))->format('Y-m-d')
            : null;

            if ($dateOfDeath && !$endOfEmployment) {
                $deathDate = new \DateTime($dateOfDeath);
                if ($deathDate > $dateOfRetirement) {
                    $endOfEmployment = $deathDate->format('Y-m-d');
                }
            }


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
