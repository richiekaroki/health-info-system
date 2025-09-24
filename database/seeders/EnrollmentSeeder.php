<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Program;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $programs = Program::all();

        if ($clients->isEmpty() || $programs->isEmpty()) {
            $this->command->warn('⚠️ No clients or programs available, skipping enrollments.');
            return;
        }

        // Enroll each client into 1–3 random programs
        foreach ($clients as $client) {
            $randomPrograms = $programs->random(rand(1, min(3, $programs->count())));

            foreach ($randomPrograms as $program) {
                $client->programs()->syncWithoutDetaching([
                    $program->id => [
                        'status' => fake()->randomElement(['active', 'completed', 'pending']),
                        'enrollment_date' => fake()->dateTimeBetween('-6 months', 'now'),
                        'completion_date' => fake()->boolean(40) ? fake()->dateTimeBetween('-3 months', 'now') : null,
                        'actual_cost' => fake()->randomFloat(2, 100, 1000),
                        'attendance_weeks' => fake()->numberBetween(1, $program->duration_weeks ?? 12),
                        'total_sessions' => fake()->numberBetween(8, 30),
                        'completed_sessions' => fake()->numberBetween(0, 30),
                        'medical_clearance' => fake()->boolean(),
                        'clearance_expiry' => fake()->boolean(60) ? fake()->dateTimeBetween('now', '+1 year') : null,
                        'assigned_coach_id' => null, // Can link to provider later if needed
                        'progress_notes' => fake()->sentence(),
                    ]
                ]);
            }
        }

        $this->command->info('✅ Random enrollments created successfully.');
    }
}
