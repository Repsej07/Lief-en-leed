<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>'liedenleed',
            'date_of_birth' => '2000-01-01',
        ]);
        User::factory()->create([
            'name' => 'Fifty Year Old',
            'email' => 'fifty@example.com',
            'password' => Hash::make('liedenleed'),
            'date_of_birth' => Carbon::now()->subYears(50)->format('Y-m-d'),
            'date_of_employment' => Carbon::now()->subYears(25),
            'end_of_employment' => null,
            'date_of_retirement' => Carbon::now()->addYears(15), // retire at 65
            'date_of_marriage' => Carbon::now()->subYears(20),
            'date_of_death' => null,
        ]);

        User::factory()->create([
            'name' => 'Sixty five Year Old',
            'email' => 'sixtyfive@example.com',
            'password' => Hash::make('liedenleed'),
            'date_of_birth' => Carbon::now()->subYears(65)->format('Y-m-d'),
            'date_of_employment' => Carbon::now()->subYears(40),
            'end_of_employment' => null,
            'date_of_retirement' => Carbon::now()->subYears(5), // retired
            'date_of_marriage' => Carbon::now()->subYears(30),
            'date_of_death' => null,
        ]);
        User::factory()->create([
            'name' => '12.5 Year Old Employee',
            'email' => 'twelve@example.com',
            'password' => Hash::make('liedenleed'),
            'date_of_birth' => Carbon::now()->subYears(30)->format('Y-m-d'),
            'date_of_employment' => Carbon::now()->subYears(12)->subMonths(6),
            'end_of_employment' => null,
            'date_of_retirement' => Carbon::now()->addYears(35), // retire at 65
            'date_of_marriage' => Carbon::now()->subYears(20),
            'date_of_death' => null
        ]);
        User::factory()->create([
            'name' => '12.5 Year Old Married',
            'email' => 'twelve5@example.com',
            'password' => Hash::make('liedenleed'),
            'date_of_birth' => Carbon::now()->subYears(30)->format('Y-m-d'),
            'date_of_employment' => Carbon::now()->subYears(12)->subMonths(6),
            'end_of_employment' => null,
            'date_of_retirement' => Carbon::now()->addYears(35), // retire at 65
            'date_of_marriage' => Carbon::now()->subYears(12)->subMonths(6),
            'date_of_death' => null
        ]);
        User::factory()->create([
            'name' => 'newly married',
            'email' => 'newmarried@example.com',
            'password' => Hash::make('liedenleed'),
            'date_of_birth' => Carbon::now()->subYears(30)->format('Y-m-d'),
            'date_of_employment' => Carbon::now()->subYears(12)->subMonths(6),
            'end_of_employment' => null,
            'date_of_retirement' => Carbon::now()->addYears(35), // retire at 65
            'date_of_marriage' => Carbon::now()->subWeek(),
            'date_of_death' => null
        ]);

        User::factory(1000)->create();
    }
}
