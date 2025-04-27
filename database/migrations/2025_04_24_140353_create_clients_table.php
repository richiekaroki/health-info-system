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
// Clients Table (Added index and comments)
Schema::create('clients', function (Blueprint $table) {
    $table->id();
    $table->string('full_name')->comment("Client's full legal name");
    $table->string('email')->unique()->comment("Primary contact email");
    $table->string('phone_number', 20)->nullable()->comment("Format: +[country code][number]");
    $table->date('birth_date')->nullable()->comment("YYYY-MM-DD format");
    $table->timestamps();

    $table->index('full_name'); // Faster search queries
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
