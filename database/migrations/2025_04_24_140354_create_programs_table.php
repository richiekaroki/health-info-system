<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            // Primary Key
            $table->id()->comment('Unique program identifier');

            // Program Details
            $table->string('code', 10)->unique()->comment('Short program identifier');
            $table->string('title')->index();
            $table->text('description');
            $table->integer('duration_weeks')->unsigned()->default(4);
            $table->decimal('cost', 10, 2)->nullable()->comment('Base price in local currency');

            // Scheduling
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('max_participants')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->enum('type', ['wellness', 'rehabilitation', 'fitness', 'education'])->default('wellness');

            // Relationships
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('category_id')->nullable()->constrained('program_categories');

            // Timestamps
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'type']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};