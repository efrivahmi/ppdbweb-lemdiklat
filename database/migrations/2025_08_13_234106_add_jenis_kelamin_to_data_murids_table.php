<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_murids', function (Blueprint $table) {
            // Menambahkan kolom jenis_kelamin setelah kolom tgl_lahir
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])
                  ->after('tgl_lahir');
        });

        // Update existing records to have default value
        DB::table('data_murids')
            ->whereNull('jenis_kelamin')
            ->orWhere('jenis_kelamin', '')
            ->update(['jenis_kelamin' => '']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_murids', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
};
