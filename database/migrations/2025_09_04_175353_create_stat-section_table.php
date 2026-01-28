<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stats_section', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->unsignedBigInteger('value')->default(0);
            $table->boolean('is_editable')->default(true);
            $table->timestamps();
        });

        DB::table('stats_section')->insert([
            [
                'label' => 'Pengunjung Website',
                'value' => 1,
                'is_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'Guru Berkualitas',
                'value' => 85,
                'is_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'Prestasi Nasional',
                'value' => 50,
                'is_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'Tahun Berdiri',
                'value' => 1990,
                'is_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('stats_section');
    }
};
