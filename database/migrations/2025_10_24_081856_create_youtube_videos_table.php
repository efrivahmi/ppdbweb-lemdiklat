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
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0)->comment('Urutan tampil video');
            $table->boolean('is_active')->default(true)->comment('Status aktif video');
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};