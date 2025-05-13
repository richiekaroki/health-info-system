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
   // Pivot Table (Added metadata)
   Schema::create('client_program', function (Blueprint $table) {
    // Modern foreign key syntax
    $table->foreignId('client_id')->constrained()->cascadeOnDelete();
    $table->foreignId('program_id')->constrained()->cascadeOnDelete();
    
    // Pivot metadata
    $table->string('status')->default('active');
    $table->date('enrollment_date')->useCurrent();
    
    // Timestamps for pivot table
    $table->timestamps(); // Creates created_at and updated_at
    
    // Composite primary key
    $table->primary(['client_id', 'program_id']);
    
    // Index for status filtering
    $table->index('status');
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_program');
    }
};