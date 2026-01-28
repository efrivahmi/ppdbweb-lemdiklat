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
            // School type to distinguish SMA vs SMK
            $table->string('school_type')->default('sma')->after('id');
            
            // Hero section data
            $table->json('hero_data')->nullable()->after('mobile_image');
            
            // School identity data (principal, school info)
            $table->json('identity_data')->nullable()->after('hero_data');
            
            // Academic programs data
            $table->json('academic_data')->nullable()->after('identity_data');
            
            // Uniform images data
            $table->json('uniform_data')->nullable()->after('academic_data');
            
            // CTA section data
            $table->json('cta_data')->nullable()->after('uniform_data');
            
            // Add unique index for school_type
            $table->unique('school_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_sekolahs', function (Blueprint $table) {
            $table->dropUnique(['school_type']);
            $table->dropColumn([
                'school_type',
                'hero_data',
                'identity_data',
                'academic_data',
                'uniform_data',
                'cta_data'
            ]);
        });
    }
};
