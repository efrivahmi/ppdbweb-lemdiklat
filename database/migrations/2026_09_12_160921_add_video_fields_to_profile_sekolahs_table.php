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
        Schema::table('profile_sekolahs', function (Blueprint $table) {
            $table->string('local_video_path')->nullable();
            $table->string('video_title')->nullable()->default('Sambutan');
            $table->text('video_description')->nullable();
            $table->boolean('video_is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_sekolahs', function (Blueprint $table) {
            $table->dropColumn(['local_video_path', 'video_title', 'video_description', 'video_is_active']);
        });
    }
};
