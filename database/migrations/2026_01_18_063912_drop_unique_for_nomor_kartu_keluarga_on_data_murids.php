<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration drops the UNIQUE constraint on 'nomor_kartu_keluarga'
     * because siblings (kakak-adik) share the same KK number.
     * A regular index is kept for search performance.
     */
    public function up(): void
    {
        $uniqueIndexName = 'data_murids_nomor_kartu_keluarga_unique';
        $regularIndexName = 'data_murids_nomor_kartu_keluarga_index';
        
        // Cek driver yang sedang digunakan (SQLite atau MySQL)
        if (DB::getDriverName() === 'sqlite') {
            $indexExists = collect(DB::select("PRAGMA index_list('data_murids')"))
                            ->where('name', $uniqueIndexName)
                            ->isNotEmpty();
        } else {
            $indexExists = collect(DB::select("SHOW INDEX FROM data_murids WHERE Key_name = ?", [$uniqueIndexName]))->isNotEmpty();
        }
        
        if ($indexExists) {
            Schema::table('data_murids', function (Blueprint $table) use ($uniqueIndexName, $regularIndexName) {
                // Gunakan string nama index langsung agar SQLite tidak bingung
                $table->dropUnique($uniqueIndexName);
                
                // Tambahkan index biasa
                $table->index('nomor_kartu_keluarga', $regularIndexName);
            });
        }
    }

    /**
     * Reverse the migrations.
     * Restores the unique constraint (for rollback scenarios).
     */
    public function down(): void
    {
        $uniqueIndexName = 'data_murids_nomor_kartu_keluarga_unique';
        $regularIndexName = 'data_murids_nomor_kartu_keluarga_index';
        
        // Cek driver yang sedang digunakan (SQLite atau MySQL)
        if (DB::getDriverName() === 'sqlite') {
            $indexExists = collect(DB::select("PRAGMA index_list('data_murids')"))
                            ->where('name', $regularIndexName)
                            ->isNotEmpty();
        } else {
            $indexExists = collect(DB::select("SHOW INDEX FROM data_murids WHERE Key_name = ?", [$regularIndexName]))->isNotEmpty();
        }
        
        if ($indexExists) {
            Schema::table('data_murids', function (Blueprint $table) use ($uniqueIndexName, $regularIndexName) {
                // Hapus index biasa
                $table->dropIndex($regularIndexName);
                
                // Kembalikan ke unique index
                $table->unique('nomor_kartu_keluarga', $uniqueIndexName);
            });
        }
    }
};