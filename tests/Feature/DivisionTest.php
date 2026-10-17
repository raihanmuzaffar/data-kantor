<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DivisionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat role dasar
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'karyawan']);
    }

    public function test_karyawan_cannot_create_division(): void
    {
        $user = User::factory()->create();
        $user->assignRole('karyawan');

        $response = $this->actingAs($user)->get('/admin/divisions/create');

        $response->assertStatus(403); // Forbidden
    }

    public function test_super_admin_can_create_division(): void
    {
        $user = User::factory()->create();
        $user->assignRole('super_admin');

        $response = $this->actingAs($user)->get('/admin/divisions/create');

        $response->assertStatus(200); // OK
    }
}
