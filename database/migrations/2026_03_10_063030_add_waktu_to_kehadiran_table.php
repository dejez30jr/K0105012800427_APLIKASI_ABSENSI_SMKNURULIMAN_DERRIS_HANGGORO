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
        Schema::table('attendance_dubes_kehadiran', function (Blueprint $table) {
            $table->datetime('waktu_masuk')->nullable();
            $table->datetime('waktu_keluar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_dubes_kehadiran', function (Blueprint $table) {
            $table->dropColumn(['waktu_masuk', 'waktu_keluar']);
        });
    }
};
