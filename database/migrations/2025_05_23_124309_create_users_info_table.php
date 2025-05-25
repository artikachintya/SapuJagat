<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary(); // PK + FK

            $table->string('address', 255);
            $table->string('province', 255);
            $table->string('city', 255);
            $table->string('postal_code', 12);
            $table->float('balance');

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_info');
    }
};

