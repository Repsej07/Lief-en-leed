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
            'Roepnaam' => 'admin',
            'Voorvoegsel' => '',
            'Achternaam' => 'user',
            'email' => 'admin@example.com',
            'password' => 'liedenleed',
            'Geboortedatum' => '2000-01-01',
            'is_admin' => true,
        ]);
        User::factory()->create([
            'Medewerker' => 2,
            'Roepnaam' => 'test',
            'Voorvoegsel' => '',
            'Achternaam' => 'user',
            'email' => 'test@example.com',
            'password' => 'liedenleed',
            'Geboortedatum' => '2000-01-01',
            'is_admin' => false,
        ]);

        User::factory(100)->create();
        requests::factory(100)->create();
    }
}
