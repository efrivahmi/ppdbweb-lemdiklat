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
         Schema::table('custom_test_questions', function (Blueprint $table) {
            $table->enum('tipe_soal', ['radio', 'text', 'checkbox'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_test_questions', function (Blueprint $table) {
            $table->enum('tipe_soal', ['radio', 'text'])->change();
        });
    }
};
