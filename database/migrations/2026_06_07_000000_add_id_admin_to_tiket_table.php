<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tiket', 'id_admin')) {
            Schema::table('tiket', function (Blueprint $table) {
                $table->foreignId('id_admin')
                    ->nullable()
                    ->after('id_agent')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
            $table->dropColumn('id_admin');
        });
    }
};
