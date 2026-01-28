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
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            
            // Badge configuration
            $table->string('badge_text')->default('Tentang Kami');
            
            // Title configuration
            $table->string('title_text');
            $table->string('title_highlight')->nullable();
            $table->string('title_class_name')->nullable();
            
            // Content - single description field
            $table->text('description');
            
            // Image configuration
            $table->string('image_url');
            $table->string('image_title');
            $table->text('image_description')->nullable();
            
            // Contact information
            $table->json('contact_info'); // Array of contact items with icon and text
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Constraint untuk memastikan hanya 1 record
            $table->boolean('is_single')->default(true);
            $table->unique('is_single'); // Ensures only one record can have is_single = true
            
            $table->timestamps();
            
            // Indexes
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about');
    }
};