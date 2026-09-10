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
        Schema::table('data_murids', function (Blueprint $table) {
            // Get the index name - Laravel naming convention: {table}_{column}_unique
            $indexName = 'data_murids_nomor_kartu_keluarga_unique';
            
            // Check if the unique index exists before dropping
            $indexExists = collect(DB::select("SHOW INDEX FROM data_murids WHERE Key_name = ?", [$indexName]))->isNotEmpty();
            
            if ($indexExists) {
                // Drop the unique constraint
                $table->dropUnique(['nomor_kartu_keluarga']);
                
                // Add a regular index for search performance
                $table->index('nomor_kartu_keluarga', 'data_murids_nomor_kartu_keluarga_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Restores the unique constraint (for rollback scenarios).
     */
    public function down(): void
    {
        Schema::table('data_murids', function (Blueprint $table) {
            $indexName = 'data_murids_nomor_kartu_keluarga_index';
            
            // Check if the regular index exists before dropping
            $indexExists = collect(DB::select("SHOW INDEX FROM data_murids WHERE Key_name = ?", [$indexName]))->isNotEmpty();
            
            if ($indexExists) {
                // Drop the regular index
                $table->dropIndex(['nomor_kartu_keluarga']);
                
                // Restore the unique constraint
                $table->unique('nomor_kartu_keluarga', 'data_murids_nomor_kartu_keluarga_unique');
            }
        });
    }
};
