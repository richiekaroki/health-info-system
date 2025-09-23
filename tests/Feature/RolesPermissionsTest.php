<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seeds DatabaseSeeder which calls RolesAndPermissionsSeeder and creates admin/provider
        $this->seed();
    }

    /** @test */
    public function roles_and_permissions_are_seeded()
    {
        $this->assertTrue(Role::where('name', 'Admin')->exists());
        $this->assertTrue(Role::where('name', 'Provider')->exists());

        $this->assertTrue(Permission::where('name', 'view clients')->exists());
        $this->assertTrue(Permission::where('name', 'create clients')->exists());
    }

    /** @test */
    public function admin_has_all_permissions()
    {
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        // Assert admin can each permission in the DB
        foreach (Permission::pluck('name') as $perm) {
            $this->assertTrue($admin->can($perm), "Admin should have permission: {$perm}");
        }
    }

    /** @test */
    public function provider_has_limited_permissions()
    {
        $provider = User::where('email', 'provider@example.com')->firstOrFail();

        $this->assertTrue($provider->can('view clients'));
        $this->assertFalse($provider->can('delete programs'));
    }
}