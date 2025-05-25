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
        Schema::create('chat_details', function (Blueprint $table) {
            $table->id('chat_detail_id')->primary();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id') // sesuai nama PK di users
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')
                ->references('chat_id') // sesuai nama PK di users
                ->on('chats')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('detail_chat',255);
            $table->string('photos',255);
            $table->dateTime('date_time');
        });
    }

    // /**
    //  * Reverse the migrations.
    //  */
    public function down(): void
    {
        Schema::dropIfExists('chat_details');
    }
};
