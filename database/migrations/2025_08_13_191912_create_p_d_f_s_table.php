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
        Schema::create('p_d_f_s', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['verifikasi', 'penerimaan'])->unique();
            $table->string('nama_sekolah');
            $table->text('alamat_sekolah');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('email');
            $table->string('telepon');
            $table->string('website')->nullable();
            $table->string('logo_kiri')->nullable();
            $table->string('logo_kanan')->nullable();
            $table->string('judul_pdf');
            $table->text('pesan_penting')->nullable();
            $table->string('nama_operator');
            $table->string('jabatan_operator');
            $table->text('catatan_tambahan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_d_f_s');
    }
};
