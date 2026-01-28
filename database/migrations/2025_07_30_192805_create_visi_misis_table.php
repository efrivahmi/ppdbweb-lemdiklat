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
        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['visi', 'misi'])->comment('Type: visi atau misi');
            $table->string('title');
            $table->text('content')->nullable()->comment('Deskripsi umum untuk visi/misi');
            $table->string('item_title')->nullable()->comment('Judul item spesifik');
            $table->text('item_description')->nullable()->comment('Deskripsi item spesifik');
            $table->integer('order')->default(0)->comment('Urutan tampil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index(['type', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visi_misi');
    }
};