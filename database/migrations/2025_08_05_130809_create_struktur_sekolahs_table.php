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
        Schema::create('struktur_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('desc')->nullable();
            $table->string('jabatan');
            $table->integer('posisi')->default(0);
            $table->string('img')->nullable();
            $table->timestamps();
            
            $table->index('posisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_sekolahs');
    }
};