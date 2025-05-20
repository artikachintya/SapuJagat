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
        Schema::create('approvals', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('order_id') // sesuai nama PK di users
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dateTime('date_time');
            $table->boolean('approval_status')->default(false)->nullable();
            $table->string('notes',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
