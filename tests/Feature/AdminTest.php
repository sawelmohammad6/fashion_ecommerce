<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create(['is_admin' => false]);
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_categories(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_products(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_orders(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/orders');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_customers(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/customers');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/settings');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_coupons(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/coupons');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_reports(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/reports');
        $response->assertStatus(200);
    }
}
