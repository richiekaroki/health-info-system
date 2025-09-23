<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Always seed roles & permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // Seed users with roles
        $this->seedUser(
            'admin@example.com',
            'Richard Karoki',
            'password',   // 🔑 change in production
            'Admin'
        );

        $this->seedUser(
            'provider@example.com',
            'Jane Provider',
            'password',   // 🔑 change in production
            'Provider'
        );
    }

    /**
     * Helper to create user & assign role
     */
    private function seedUser(string $email, string $name, string $password, string $role): void
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }
    }
}