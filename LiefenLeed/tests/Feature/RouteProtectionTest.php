<?php
// tests/Feature/RouteProtectionTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RouteProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_admin_role()
    {
        $regularUser = User::factory()->create(['is_admin' => false]);
        $adminUser = User::factory()->create(['is_admin' => true]);

        $adminRoutes = [
            '/request/index',
            '/import',
            '/profile'
        ];

        foreach ($adminRoutes as $route) {
            // Reguliere gebruiker wordt geweigerd
            $response = $this->actingAs($regularUser)->get($route);
            $response->assertStatus(403);

            // Admin krijgt toegang
            $response = $this->actingAs($adminUser)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_employee_search_is_accessible_to_authenticated_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/search-employees');
        $response->assertStatus(200);
    }
}
