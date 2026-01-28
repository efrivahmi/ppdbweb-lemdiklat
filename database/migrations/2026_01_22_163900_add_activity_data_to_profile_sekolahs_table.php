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
            $table->json('activity_data')->nullable()->after('uniform_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_sekolahs', function (Blueprint $table) {
            $table->dropColumn('activity_data');
        });
    }
};
