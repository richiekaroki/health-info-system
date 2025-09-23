<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            'enroll clients',
            'unenroll clients',
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'view program clients',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $providerRole = Role::firstOrCreate(['name' => 'Provider']);

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());
        $providerRole->syncPermissions([
            'view clients',
            'enroll clients',
            'unenroll clients',
            'view programs',
            'view program clients',
        ]);

        // Create default admin user only if it does not exist
        $adminUser = User::firstOrCreate(
            ['email' => 'richard.karoki@example.com'],
            [
                'name' => 'Richard Karoki',
                'password' => Hash::make('password123'), // ⚠️ change later
            ]
        );

        // Ensure Admin role is assigned
        if (!$adminUser->hasRole('Admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}