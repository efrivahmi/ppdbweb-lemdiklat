<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->comment('Heroicon name without prefix (e.g., academic-cap)');
            $table->string('title');
            $table->text('description');
            $table->integer('order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'order']);
        });

        // Insert default data
        DB::table('advantages')->insert([
            [
                'icon' => 'academic-cap',
                'title' => 'Pendidikan Karakter Berbasis Kedisiplinan',
                'description' => 'Program pendidikan dan pelatihan terbaik dengan standar militer yang membentuk karakter kepemimpinan unggul',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'trophy',
                'title' => 'Prestasi Tingkat Nasional',
                'description' => 'Lulusan Taruna Nusantara telah meraih berbagai penghargaan dan prestasi di tingkat nasional dan internasional',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'user-group',
                'title' => 'Instruktur Profesional Berpengalaman',
                'description' => 'Dibimbing oleh instruktur militer profesional dan tenaga pendidik bersertifikasi dengan pengalaman lebih dari 10 tahun',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Akreditasi A - BAN PT',
                'description' => 'Terakreditasi A oleh Badan Akreditasi Nasional Perguruan Tinggi periode 2023-2028',
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'building-library',
                'title' => 'Fasilitas Kelas Dunia',
                'description' => 'Dilengkapi dengan fasilitas pelatihan modern, asrama nyaman, dan area latihan lapangan yang memadai',
                'order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'globe-asia-australia',
                'title' => 'Jaringan Alumni Luas',
                'description' => 'Memiliki jaringan alumni yang kuat di berbagai sektor pemerintahan, TNI, POLRI, dan swasta',
                'order' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantages');
    }
};