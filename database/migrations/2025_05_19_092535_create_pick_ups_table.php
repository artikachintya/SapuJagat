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
            $table->id('pick_up_id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('order_id') // sesuai nama PK di users
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedBigInteger('driver_id');
            // $table->foreign('driver_id')
            //     ->references('driver_id') // sesuai nama PK di users
            //     ->on('drivers')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            $table->string('driver_id', 5);
            $table->foreign('driver_id')
                ->references('driver_id')
                ->on('drivers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dateTime('pick_up_date');
            $table->datetime('arrival_date');
            $table->string('photos',255);
            $table->string('notes',255);
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
