<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->dateTime('session_date');
            $table->integer('duration_minutes')->unsigned()->default(60);
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->foreignId('conducted_by')->nullable()->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index(['client_id', 'session_date']);
            $table->index(['program_id', 'session_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
