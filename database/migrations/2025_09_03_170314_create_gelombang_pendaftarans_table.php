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
        Schema::create('gelombang_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gelombang');
            $table->dateTime('pendaftaran_mulai');
            $table->dateTime('pendaftaran_selesai');
            $table->dateTime('ujian_mulai');
            $table->dateTime('ujian_selesai');
            $table->dateTime('pengumuman_tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombang_pendaftarans');
    }
};
