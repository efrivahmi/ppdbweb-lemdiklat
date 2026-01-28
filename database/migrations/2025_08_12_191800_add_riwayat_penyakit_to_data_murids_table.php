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
        Schema::table('data_murids', function (Blueprint $table) {
            $table->text('riwayat_penyakit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_murids', function (Blueprint $table) {
            $table->dropColumn('riwayat_penyakit');
        });
    }
};
