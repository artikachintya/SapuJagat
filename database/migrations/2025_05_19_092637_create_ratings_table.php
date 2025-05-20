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
        Schema::create('ratings', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('order_id') // sesuai nama PK di users
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id') // sesuai nama PK di users
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('star_rating')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
