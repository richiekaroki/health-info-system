<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            // Primary Key
            $table->id()->comment('Unique client identifier');

            // Personal Information
            $table->string('full_name')->index()->comment("Client's full legal name");
            $table->string('preferred_name')->nullable()->comment("Name for informal communication");
            $table->string('email')->unique()->comment("Primary contact email");
            $table->string('phone', 20)->nullable()->comment("E.164 format: +[country code][number]");
            $table->string('phone_alt', 20)->nullable()->comment("Secondary contact number");
            $table->date('birth_date')->nullable()->comment("YYYY-MM-DD format");
            $table->enum('gender', ['male', 'female', 'non-binary', 'other', 'prefer_not_to_say'])->nullable();

            // Address Information
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country_code', 2)->nullable()->comment('ISO 3166-1 alpha-2');

            // Medical Information
            $table->string('blood_type', 3)->nullable()->comment('ABO-Rh format');
            $table->text('known_allergies')->nullable();
            $table->text('medical_conditions')->nullable();

            // System Fields
            $table->foreignId('created_by')->constrained('users')->comment('Staff who created record');
            $table->foreignId('primary_provider_id')->nullable()->constrained('users')->comment('Main healthcare provider');
            $table->enum('status', ['prospect', 'active', 'inactive', 'archived'])->default('prospect');
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable()->comment('Additional client-specific data');

            // Timestamps
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['primary_provider_id', 'status']);
            $table->fullText(['full_name', 'email', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};