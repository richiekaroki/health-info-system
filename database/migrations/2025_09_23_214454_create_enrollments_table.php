<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->date('enrollment_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->integer('attendance_weeks')->nullable();
            $table->integer('total_sessions')->nullable();
            $table->integer('completed_sessions')->nullable();
            $table->boolean('medical_clearance')->default(false);
            $table->date('clearance_expiry')->nullable();
            $table->foreignId('assigned_coach_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('progress_notes')->nullable();
            $table->timestamps();

            $table->unique(['client_id', 'program_id']); // prevent duplicate enrollments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
