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
        Schema::create('pick_ups', function (Blueprint $table) {

            $table->id('pick_up_id')-> primary();

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

            $table->dateTime('start_time')-> nullable();
            $table->dateTime('pick_up_date')-> nullable();
            $table->dateTime('arrival_date')-> nullable();
            $table->string('photos',255)-> nullable();
            $table->string('notes',255)-> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pick_ups');
    }
};
