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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id')->primary();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id') // sesuai nama PK di users
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dateTime('date_time_request');
            $table->string('pickup_time',255);
            $table->string('photo',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
