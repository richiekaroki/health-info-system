<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_program', function (Blueprint $table) {
            // Foreign Keys
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();

            // Enrollment Details
            $table->enum('status', ['pending', 'active', 'paused', 'completed', 'terminated'])->default('pending');
            $table->date('enrollment_date')->useCurrent();
            $table->date('completion_date')->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable()->comment('Final charged amount');

            // Progress Tracking
            $table->integer('attendance_weeks')->unsigned()->default(0);
            $table->integer('total_sessions')->unsigned()->nullable();
            $table->integer('completed_sessions')->unsigned()->default(0);

            // Medical Approval
            $table->boolean('medical_clearance')->default(false);
            $table->date('clearance_expiry')->nullable();

            // Staff Tracking
            $table->foreignId('assigned_coach_id')->nullable()->constrained('users');
            $table->text('progress_notes')->nullable();

            // Timestamps
            $table->timestamps();

            // Composite Primary Key
            $table->primary(['client_id', 'program_id']);

            // Indexes
            $table->index('status');
            $table->index('enrollment_date');
            $table->index(['medical_clearance', 'clearance_expiry']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_program');
    }
};
