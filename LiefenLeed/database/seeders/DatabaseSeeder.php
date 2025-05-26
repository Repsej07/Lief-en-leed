<?php

namespace Database\Seeders;

use App\Models\bus;
use App\Models\festivals; // Use the correct festivals model
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         // User::factory(10)->create();
         User::factory()->create([
            'Medewerker' => 1,
            'Roepnaam' => 'Test',
            'Voorvoegsel' => 'de',
            'Achternaam' => 'Tester',
            'E-mail_werk' => 'test@example.com',
            'password'=>'liedenleed',
            'Geboortedatum' => '2000-01-01',
            'is_admin' => true,
        ]);

        User::factory(1000)->create();
    }
    }
