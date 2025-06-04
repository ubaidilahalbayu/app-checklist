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
        Schema::create('checklist_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user');
            $table->date('tanggal');
            $table->time('jam');
            $table->json('checklist');
            $table->text('photo');

            $table->timestamps();
            $table->primary(['user', 'tanggal']);
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_user');
    }
};
