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
        Schema::table('hero_profiles', function (Blueprint $table) {
            $table->string('title')->nullable()->after('image');
            $table->string('image_mobile')->nullable()->after('title');
            $table->integer('order')->default(0)->after('image_mobile');
            $table->boolean('is_active')->default(true)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_profiles', function (Blueprint $table) {
            $table->dropColumn(['title', 'image_mobile', 'order', 'is_active']);
        });
    }
};
