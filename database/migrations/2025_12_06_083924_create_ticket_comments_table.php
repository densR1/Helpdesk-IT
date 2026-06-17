<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tiket_id');
            $table->unsignedBigInteger('user_id');

            $table->text('komentar');
            $table->string('attachment', 255)->nullable();

            $table->timestamps();

            // FIX DI SINI
            $table->foreign('tiket_id', 'ticket_comments_tiket_id_foreign')
                  ->references('id_tiket') // <-- ini yang bener
                  ->on('tiket')
                  ->onDelete('cascade');

            $table->foreign('user_id', 'ticket_comments_user_id_foreign')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_comments');
    }
};