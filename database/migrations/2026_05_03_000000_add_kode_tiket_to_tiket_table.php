<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tiket', 'kode_tiket')) {
    Schema::table('tiket', function (Blueprint $table) {
        $table->string('kode_tiket')->nullable()->unique();
    });
}
    }

    public function down(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};
