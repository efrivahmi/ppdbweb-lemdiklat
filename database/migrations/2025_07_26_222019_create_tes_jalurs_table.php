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
        Schema::create('tes_jalurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_pendaftaran_id')->constrained('jalur_pendaftarans')->onDelete('cascade');
            $table->string('nama_tes');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tes_jalurs');
    }
};