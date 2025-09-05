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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->string('academic_degree')->nullable();
            $table->foreignId('role_id')->default(2)->constrained('roles');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city', 'workplace', 'position', 'academic_degree', 'is_verified']);
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
