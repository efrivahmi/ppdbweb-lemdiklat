<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();

            // Badge
            $table->string('badge_text')->nullable();
            $table->string('badge_variant')->default('indigo');
            $table->string('badge_size')->default('md');

            // Title
            $table->string('title_text');
            $table->string('title_highlight')->nullable();
            $table->string('title_size')->default('3xl');
            $table->string('title_class')->nullable();

            // Description
            $table->text('descriptions')->nullable(); // JSON array atau teks panjang

            // Main Image
            $table->string('image_url')->nullable();
            $table->string('image_title')->nullable();
            $table->string('image_description')->nullable();

            // Empat foto tambahan (wajib)
            $table->string('photo_1_url')->nullable();
            $table->string('photo_1_title')->default('Bela Negara');
            $table->string('photo_2_url')->nullable();
            $table->string('photo_2_title')->default('Kenusantaraan');
            $table->string('photo_3_url')->nullable();
            $table->string('photo_3_title')->default('Terproyek');

            // Flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_single')->default(true);
            $table->unique('is_single'); // pastikan cuma ada 1 record

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
