<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions + Roles
        $this->call(RolesAndPermissionsSeeder::class);

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Richard Karoki',
                'password' => Hash::make('password'),
            ]
        );
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        // Create provider
        $provider = User::firstOrCreate(
            ['email' => 'provider@example.com'],
            [
                'name' => 'Jane Provider',
                'password' => Hash::make('password'),
            ]
        );
        if (!$provider->hasRole('Provider')) {
            $provider->assignRole('Provider');
        }

        // Sample Program
        $program = Program::firstOrCreate(
            ['name' => 'Wellness Bootcamp'],
            [
                'code' => 'WBC01',
                'description' => 'A 12-week intensive wellness & fitness bootcamp.',
                'duration_weeks' => 12,
                'is_active' => true,
                'created_by' => $admin->id,
                'cost' => 500,
                'type' => 'Fitness',
            ]
        );

        // Sample Client
        $client = Client::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'preferred_name' => 'John',
                'phone' => '123456789',
                'birth_date' => '1990-01-01',
                'created_by' => $provider->id,
                'primary_provider_id' => $provider->id,
                'status' => 'active',
            ]
        );

        // Attach enrollment via pivot if not already attached
        $client->programs()->syncWithoutDetaching([
            $program->id => [
                'status' => 'active',
                'enrollment_date' => now(),
            ]
        ]);
    }
}