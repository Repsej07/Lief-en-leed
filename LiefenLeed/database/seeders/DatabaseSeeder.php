<?php

namespace Database\Seeders;

use App\Models\bus;
use App\Models\festivals; // Use the correct festivals model
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
            'is_admin' => true
            ]);
    }
}
