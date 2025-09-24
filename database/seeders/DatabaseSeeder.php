<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. Seed Roles & Permissions
        // ==========================================
        $this->call(RolesAndPermissionsSeeder::class);

        // ==========================================
        // 2. Create Users (Admin + Provider)
        // ==========================================
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

        // ==========================================
        // 3. Create Program Category
        // ==========================================
        $category = ProgramCategory::firstOrCreate(
            ['slug' => 'wellness'],
            [
                'name' => 'Wellness Programs',
                'description' => 'Health and wellness programs',
                'is_active' => true,
            ]
        );

        // ==========================================
        // 4. Create Programs
        // ==========================================
        $programs = [
            [
                'name' => 'Wellness Bootcamp',
                'code' => 'WBC01',
                'description' => 'A 12-week intensive wellness & fitness bootcamp.',
                'duration_weeks' => 12,
                'is_active' => true,
                'cost' => 500,
                'type' => 'Fitness',
                'category_id' => $category->id,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Weight Management Program',
                'code' => 'WMP001',
                'description' => 'Comprehensive weight management program',
                'duration_weeks' => 12,
                'is_active' => true,
                'cost' => 299.99,
                'type' => 'Wellness',
                'category_id' => $category->id,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Diabetes Prevention Program',
                'code' => 'DPP001',
                'description' => 'Evidence-based diabetes prevention',
                'duration_weeks' => 16,
                'is_active' => true,
                'cost' => 399.99,
                'type' => 'Medical',
                'category_id' => $category->id,
                'created_by' => $admin->id,
            ]
        ];

        foreach ($programs as $programData) {
            Program::firstOrCreate(['code' => $programData['code']], $programData);
        }

        // ==========================================
        // 5. Create Clients
        // ==========================================
        $clients = [
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'preferred_name' => 'John',
                'email' => 'john@example.com',
                'phone' => '123456789',
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'created_by' => $provider->id,
                'primary_provider_id' => $provider->id,
                'status' => 'active',
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'preferred_name' => 'Jane',
                'email' => 'jane.smith@example.com',
                'phone' => '987654321',
                'birth_date' => '1992-05-10',
                'gender' => 'female',
                'created_by' => $provider->id,
                'primary_provider_id' => $provider->id,
                'status' => 'active',
            ]
        ];

        foreach ($clients as $clientData) {
            Client::firstOrCreate(['email' => $clientData['email']], $clientData);
        }

        // ==========================================
        // 6. Enroll Clients into Programs
        // ==========================================
        $john = Client::where('email', 'john@example.com')->first();
        $jane = Client::where('email', 'jane.smith@example.com')->first();
        $bootcamp = Program::where('code', 'WBC01')->first();
        $weightMgmt = Program::where('code', 'WMP001')->first();

        if ($john && $bootcamp) {
            $john->programs()->syncWithoutDetaching([
                $bootcamp->id => [
                    'status' => 'active',
                    'enrollment_date' => now(),
                ]
            ]);
        }

        if ($jane && $weightMgmt) {
            $jane->programs()->syncWithoutDetaching([
                $weightMgmt->id => [
                    'status' => 'active',
                    'enrollment_date' => now(),
                ]
            ]);
        }
    }
}