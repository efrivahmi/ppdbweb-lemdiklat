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
        Schema::create('persyaratans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['physical', 'document'])->comment('Tipe persyaratan: physical atau document');
            $table->string('title')->comment('Judul/nama persyaratan');
            $table->text('description')->nullable()->comment('Deskripsi persyaratan');
            $table->string('value')->comment('Nilai persyaratan (tinggi/berat/jumlah)');
            $table->string('unit')->nullable()->comment('Satuan (cm/kg/lembar/buah)');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('Jenis kelamin (khusus untuk physical)');
            $table->string('color', 50)->nullable()->comment('Warna untuk styling UI');
            $table->boolean('is_active')->default(true)->comment('Status aktif persyaratan');
            $table->integer('order')->default(0)->comment('Urutan tampil');
            $table->timestamps();

            // Indexes
            $table->index(['type', 'is_active']);
            $table->index(['gender', 'type']);
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratans');
    }
};