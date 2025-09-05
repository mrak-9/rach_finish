<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Создаем роли по умолчанию
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Администратор', 'description' => 'Полный доступ к административной панели'],
            ['id' => 2, 'name' => 'user', 'display_name' => 'Пользователь', 'description' => 'Обычный пользователь'],
            ['id' => 3, 'name' => 'verified_user', 'display_name' => 'Подтвержденный пользователь', 'description' => 'Пользователь с подтвержденным email'],
            ['id' => 4, 'name' => 'guest', 'display_name' => 'Посетитель', 'description' => 'Неавторизованный пользователь'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
