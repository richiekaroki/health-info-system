<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    if (!Schema::hasTable('programs')) {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('duration_weeks')->unsigned()->default(4);
            $table->decimal('cost', 10, 2)->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); // No FK here
            $table->unsignedBigInteger('created_by')->nullable(); // No FK here
            $table->boolean('is_active')->default(true);
            $table->enum('type', ['wellness','rehabilitation','fitness','education'])->default('wellness');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
