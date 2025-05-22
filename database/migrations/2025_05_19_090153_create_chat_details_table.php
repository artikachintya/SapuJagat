<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('chat_details', function (Blueprint $table) {
    //         $table->id('ud_id');
    //         $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade')->onUpdate('cascade');
    //         $table->string('detail_chat',255);
    //         $table->string('photos',255);
    //         $table->dateTime('date_time');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('chat_details');
    // }
    public function up(): void
    {
        Schema::create('chat_details', function (Blueprint $table) {
            $table->id('chatdetail_id'); // Ini ganti dari default 'id' ke 'chatdetail_id'

            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');

            // FK ke user dan driver
            $table->string('user_id')->nullable();
            $table->string('driver_id')->nullable();

            $table->text('detail_chat');
            $table->string('photos', 255)->nullable();
            $table->dateTime('date_time');

            // FK constraint
            $table->foreign('user_id')->references('user_id')->on('users')->nullOnDelete();
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->nullOnDelete();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('chat_details');
    }
};
