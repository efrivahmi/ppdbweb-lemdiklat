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
        Schema::create('sambutan_kepala_sekolahs', function (Blueprint $table) {
            $table->id();
            
            // Badge Section
            $table->string('badge_text')->default('Sambutan');
            $table->string('badge_variant')->default('indigo');
            $table->string('badge_size')->default('md');
            
            // Title Section
            $table->string('title_text')->default('Sambutan Kepala Sekolah');
            $table->string('title_highlight')->nullable();
            $table->string('title_size')->default('3xl');
            $table->string('title_class_name')->default('lg:text-5xl');
            
            // Principal Information
            $table->string('principal_name');
            $table->string('principal_title')->default('Kepala Sekolah');
            $table->string('principal_image')->nullable();
            $table->string('principal_signature')->nullable();
            
            // Greeting Content
            $table->text('greeting_opening');
            $table->json('greeting_paragraphs');
            $table->text('greeting_closing');
            
            // Quote Section
            $table->text('quote_text')->nullable();
            $table->string('quote_author')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sambutan_kepala_sekolahs');
    }
};