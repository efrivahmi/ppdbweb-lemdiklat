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
        Schema::table('data_orang_tuas', function (Blueprint $table) {
            $table->string('status_pekerjaan_ayah')->nullable()->after('pekerjaan_ayah');
            $table->string('status_pekerjaan_ibu')->nullable()->after('pekerjaan_ibu');
            $table->string('status_pekerjaan_wali')->nullable()->after('pekerjaan_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_orang_tuas', function (Blueprint $table) {
            $table->dropColumn(['status_pekerjaan_ayah', 'status_pekerjaan_ibu', 'status_pekerjaan_wali']);
        });
    }
};
