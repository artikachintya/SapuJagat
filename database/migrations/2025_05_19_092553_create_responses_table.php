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
        Schema::create('responses', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')
                ->references('admin_id') // sesuai nama PK di users
                ->on('admins')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')
                ->references('report_id') // sesuai nama PK di users
                ->on('reports')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('response_message',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
