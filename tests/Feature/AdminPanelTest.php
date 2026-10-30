<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_admin_can_access_resource_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        foreach (['/admin/news', '/admin/services', '/admin/events', '/admin/documents', '/admin/faqs', '/admin/users'] as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }

    public function test_non_admin_cannot_access_panel(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($petugas)->get('/admin')->assertForbidden();
    }
}
