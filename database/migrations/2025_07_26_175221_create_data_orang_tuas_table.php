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
        Schema::create('data_orang_tuas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->unique()->onDelete('cascade');
            $table->string('nama_ayah')->nullable();
            $table->string('pendidikan_ayah', 50)->nullable();
            $table->string('telp_ayah')->nullable();
            $table->string('pekerjaan_ayah', 50)->nullable();
            $table->string('alamat_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pendidikan_ibu', 50)->nullable();
            $table->string('telp_ibu')->nullable();
            $table->string('pekerjaan_ibu', 50)->nullable();
            $table->string('alamat_ibu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('pendidikan_wali', 50)->nullable();
            $table->string('telp_wali')->nullable();
            $table->string('pekerjaan_wali', 50)->nullable();
            $table->string('alamat_wali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_orang_tuas');
    }
};
