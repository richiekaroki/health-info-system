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
        // Programs Table (Added constraints)
Schema::create('programs', function (Blueprint $table) {
    $table->id();
    $table->string('title')->comment("Official program name");
    $table->text('summary')->nullable()->comment("Brief 1-2 paragraph description");
    $table->boolean('is_active')->default(true)->comment("Program availability flag");
    $table->timestamps();
});
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};