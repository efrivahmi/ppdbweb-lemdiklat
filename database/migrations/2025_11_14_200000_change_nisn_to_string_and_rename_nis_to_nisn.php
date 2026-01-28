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
        // Ubah tipe data nisn di tabel users dari integer ke string
        // Tidak perlu unique() karena constraint sudah ada
        Schema::table('users', function (Blueprint $table) {
            $table->string('nisn', 10)->nullable()->change();
        });

        // Rename kolom nis menjadi nisn di tabel data_murids
        Schema::table('data_murids', function (Blueprint $table) {
            $table->renameColumn('nis', 'nisn');
        });

        // Ubah tipe data nisn di tabel data_murids dari integer ke string
        // Tidak perlu unique() karena constraint sudah ada dari kolom nis
        Schema::table('data_murids', function (Blueprint $table) {
            $table->string('nisn', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nisn ke integer di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->integer('nisn')->nullable()->change();
        });

        // Ubah kembali tipe data di data_murids sebelum rename
        Schema::table('data_murids', function (Blueprint $table) {
            $table->integer('nisn')->unsigned()->nullable()->change();
        });

        // Rename kolom nisn kembali menjadi nis
        Schema::table('data_murids', function (Blueprint $table) {
            $table->renameColumn('nisn', 'nis');
        });
    }
};
