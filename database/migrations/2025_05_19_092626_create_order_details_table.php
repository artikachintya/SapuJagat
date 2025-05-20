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
        Schema::create('order_details', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('order_id') // sesuai nama PK di users
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('trash_id');
            $table->foreign('trash_id')
                ->references('trash_id') // sesuai nama PK di users
                ->on('trashes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('quantity')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
