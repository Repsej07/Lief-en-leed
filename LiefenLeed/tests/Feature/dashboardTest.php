<?php
// tests/Feature/DashboardTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\gebeurtenissen;
use App\Models\requests;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_all_gebeurtenissen()
    {
        // Seed de database met gebeurtenissen zoals in jouw migratie
        gebeurtenissen::create(['type' => '25 Jaar Ambtenaar']);
        gebeurtenissen::create(['type' => 'Pensionering']);
        gebeurtenissen::create(['type' => '50e Verjaardag']);

        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('25 Jaar Ambtenaar');
        $response->assertSee('Pensionering');
        $response->assertSee('50e Verjaardag');
    }
    public function test_employee_not_found_returns_error()
    {
        $requester = User::factory()->create();

        $response = $this->actingAs($requester)->post('/aanvraag', [
            'medewerker' => 99999, // Niet bestaand medewerkernummer
            'type' => 'Ziekte'
        ]);

        $response->assertSessionHasErrors(['medewerker' => 'Medewerker niet gevonden']);
    }
}
