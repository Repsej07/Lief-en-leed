<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\requests;

class RequestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_view_requests_index()
    {
        $regularUser = User::factory()->create(['is_admin' => false]);
        $adminUser = User::factory()->create(['is_admin' => true]);

        // Reguliere gebruiker wordt geweigerd
        $response = $this->actingAs($regularUser)->get('/request/index');
        $response->assertStatus(403);

        // Admin krijgt toegang
        $response = $this->actingAs($adminUser)->get('/request/index');
        $response->assertStatus(200);
        $response->assertViewIs('request.index');
    }

    public function test_admin_can_approve_request()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $request = requests::factory()->create([
            'type' => 'Ziekte 3 maanden',
            'approved' => false
        ]);

        $response = $this->actingAs($admin)->post("/request/{$request->id}/goedkeuren");

        $response->assertStatus(302);
        $response->assertRedirect('/request/index');
        $response->assertSessionHas('success', 'Aanvraag goedgekeurd.');

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'approved' => true
        ]);
    }

    public function test_admin_can_reject_request()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $request = requests::factory()->create([
            'type' => 'Ziekte',
            'approved' => false
        ]);

        $response = $this->actingAs($admin)->post("/request/{$request->id}/afkeuren");

        $response->assertStatus(302);
        $response->assertRedirect('/request/index');
        $response->assertSessionHas('error', 'Aanvraag verwijderd.');

        $this->assertDatabaseMissing('requests', [
            'id' => $request->id
        ]);
    }
}
