<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (config('database.default') === 'sqlite') {
                // SQLite: pakai string biasa
                $table->string('role')->default('siswa')->change();
            } else {
                // MySQL: pakai ENUM
                $table->enum('role', ['admin', 'siswa', 'guru'])
                      ->default('siswa')
                      ->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (config('database.default') === 'sqlite') {
                $table->string('role')->default('siswa')->change();
            } else {
                $table->enum('role', ['admin', 'siswa'])
                      ->default('siswa')
                      ->change();
            }
        });
    }
};
