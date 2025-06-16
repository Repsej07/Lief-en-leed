<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\requests;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'Medewerker' => 1,
            'Roepnaam' => 'Test',
            'Voorvoegsel' => 'de',
            'Achternaam' => 'Tester',
            'email' => 'test@example.com',
            'password' => 'liedenleed',
            'Geboortedatum' => '2000-01-01',
            'is_admin' => true,
        ]);

        User::factory(10)->create();
        requests::factory(10)->create();
    }
}
