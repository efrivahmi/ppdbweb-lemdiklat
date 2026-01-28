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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('nisn')->unique()->nullable()->after('name');
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->after('email');
            $table->string('telp')->nullable()->after('role');
            $table->string('foto_profile')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nisn');
            $table->dropColumn('role');
            $table->dropColumn('telp');
            $table->dropColumn('foto_profile');
        });
    }
};
