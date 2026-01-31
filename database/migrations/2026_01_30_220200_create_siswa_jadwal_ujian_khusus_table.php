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
        Schema::create('siswa_jadwal_ujian_khusus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jadwal_ujian_khusus_id')->constrained('jadwal_ujian_khusus')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'jadwal_ujian_khusus_id'], 'siswa_jadwal_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_jadwal_ujian_khusus');
    }
};
