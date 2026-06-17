<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id('id_tiket');

            $table->foreignId('id_user_create')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('id_kategori')
                ->constrained('kategori')
                ->onDelete('cascade');

            $table->string('judul');
            $table->string('attachment')->nullable();
            $table->text('deskripsi')->nullable();

            // status: 0 = Open, 1 = On-Progress, 2 = Confirm, 3 = Completed
            $table->tinyInteger('status')->default(0);

            $table->foreignId('id_agent')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('note')->nullable();
            $table->timestamp('date_selesai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
