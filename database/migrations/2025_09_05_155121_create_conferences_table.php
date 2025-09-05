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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('registration_start_date');
            $table->date('conference_start_date');
            $table->date('conference_end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('conference_type')->nullable();
            $table->longText('announcement')->nullable();
            $table->longText('description')->nullable();
            $table->longText('post_release')->nullable();
            $table->json('important_dates')->nullable();
            $table->json('events')->nullable(); // дата-формат участия-тип участника
            $table->boolean('is_active')->default(true);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
