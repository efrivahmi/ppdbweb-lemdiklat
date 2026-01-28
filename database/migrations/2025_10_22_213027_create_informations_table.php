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
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->string('icon'); // Heroicon name
            $table->string('title');
            $table->string('url');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'order']);
            $table->index('order');
        });

        // Insert default data
        DB::table('informations')->insert([
            [
                'icon' => 'book-open',
                'title' => 'Program Pelatihan',
                'url' => '/program-pelatihan',
                'description' => 'Informasi lengkap tentang program pelatihan',
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'banknotes',
                'title' => 'Biaya Pelatihan',
                'url' => '/biaya-pelatihan',
                'description' => 'Rincian biaya pelatihan dan pembayaran',
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'academic-cap',
                'title' => 'Beasiswa',
                'url' => '/beasiswa',
                'description' => 'Informasi program beasiswa yang tersedia',
                'is_active' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'phone',
                'title' => 'Kontak Penting',
                'url' => '/kontak',
                'description' => 'Hubungi kami untuk informasi lebih lanjut',
                'is_active' => true,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'calendar-days',
                'title' => 'Jadwal Seleksi',
                'url' => '/jadwal-seleksi',
                'description' => 'Jadwal dan timeline seleksi peserta',
                'is_active' => true,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'credit-card',
                'title' => 'Layanan Pembayaran',
                'url' => '/pembayaran',
                'description' => 'Metode dan cara pembayaran',
                'is_active' => true,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'document-text',
                'title' => 'Pengunduhan Diri',
                'url' => '/pengunduhan-diri',
                'description' => 'Proses pengunduhan diri peserta',
                'is_active' => true,
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'calendar-days',
                'title' => 'Awal Pelatihan',
                'url' => '/awal-pelatihan',
                'description' => 'Informasi awal mula pelatihan',
                'is_active' => true,
                'order' => 8,
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
        Schema::dropIfExists('informations');
    }
};