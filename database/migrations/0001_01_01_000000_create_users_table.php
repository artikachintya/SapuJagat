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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')-> primary(); // Primary key
            $table->string('name', 100);
            $table->string('NIK', 20)->nullable()->unique();
            $table->string('email', 100)->unique();
            $table->string('phone_num', 20)->nullable()->unique();
            $table->string('password', 255);
            $table->boolean('status')->default(false);
            $table->integer('role');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
