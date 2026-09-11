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
        Schema::table('gelombang_pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->after('id');
            
            // Opsional: Jika ingin strict constraint
            // $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gelombang_pendaftarans', function (Blueprint $table) {
            // $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};
