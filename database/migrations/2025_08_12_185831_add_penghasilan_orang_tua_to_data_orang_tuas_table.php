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
            $table->string('penghasilan_ayah', 50)->nullable()->after('alamat_ayah');
            $table->string('penghasilan_ibu', 50)->nullable()->after('alamat_ibu');
            $table->string('penghasilan_wali', 50)->nullable()->after('alamat_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_orang_tuas', function (Blueprint $table) {
            $table->dropColumn('penghasilan_ayah');
            $table->dropColumn('penghasilan_ibu');
            $table->dropColumn('penghasilan_wali');
        });
    }
};
