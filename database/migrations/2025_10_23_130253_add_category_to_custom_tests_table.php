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
        Schema::table('custom_tests', function (Blueprint $table) {
            $table->enum('category', ['custom_test', 'kuesioner_ortu'])->default('custom_test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_tests', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
