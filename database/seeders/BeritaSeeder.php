<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\Berita;
use App\Models\Landing\KategoriBerita;
use App\Models\User;
use Carbon\Carbon;
use Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        // Pastikan kategori sudah ada
        if (KategoriBerita::count() === 0) {
            $this->call(KategoriBeritaSeeder::class);
        }
         if (User::where('role', 'admin')->count() === 0) {
            $this->call(AdminDefaultSeeder::class);
        }

        // Ambil user admin pertama
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin?->id;

        if (!$adminId) {
            $this->command->error('Admin tidak ditemukan. Seeder gagal.');
            return;
        }

        $categories = KategoriBerita::all();
        

        $beritas = [
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2024/2025 Telah Dibuka',
                'content' => 'Pendaftaran siswa baru tahun ajaran 2024/2025 telah resmi dibuka dengan berbagai program unggulan. Calon siswa dapat mendaftar melalui sistem online yang telah disediakan dengan syarat dan ketentuan yang berlaku. Program unggulan meliputi kelas MIPA unggulan, kelas bahasa internasional, dan program akselerasi untuk siswa berprestasi.',
                'kategori_id' => $categories->where('name', 'Pendaftaran')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-15 08:00:00'),
                'updated_at' => Carbon::parse('2024-07-15 08:00:00'),
            ],
            [
                'title' => 'Siswa Lemdiklat Taruna Nusantara Indonesia Raih Juara 1 Olimpiade Matematika Nasional',
                'content' => 'Tim matematika Lemdiklat Taruna Nusantara Indonesia berhasil meraih juara 1 dalam olimpiade matematika tingkat nasional. Prestasi ini merupakan hasil kerja keras dan dedikasi dari siswa dan guru pembimbing. Ahmad Rizki Pratama dari kelas XII IPA 1 berhasil mengalahkan pesaing dari seluruh Indonesia dengan skor sempurna.',
                'kategori_id' => $categories->where('name', 'Prestasi')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1584697964358-3e14ca57658b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-10 10:30:00'),
                'updated_at' => Carbon::parse('2024-07-10 10:30:00'),
            ],
            [
                'title' => 'Workshop Teknologi AI dan Machine Learning untuk Siswa Kelas XI',
                'content' => 'Sekolah mengadakan workshop teknologi AI dan Machine Learning untuk meningkatkan kemampuan siswa dalam bidang teknologi modern. Workshop ini dihadiri oleh seluruh siswa kelas XI dengan narasumber dari industri teknologi terkemuka. Materi meliputi pengenalan AI, machine learning basics, dan hands-on programming dengan Python.',
                'kategori_id' => $categories->where('name', 'Kegiatan')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-08 14:00:00'),
                'updated_at' => Carbon::parse('2024-07-08 14:00:00'),
            ],
            [
                'title' => 'Pengumuman Libur Semester dan Kegiatan Remedial',
                'content' => 'Pengumuman resmi mengenai jadwal libur semester genap dan kegiatan remedial untuk siswa yang memerlukan perbaikan nilai. Kegiatan remedial akan dilaksanakan sebelum libur semester dimulai. Program remedial tersedia untuk semua mata pelajaran dengan jadwal yang telah disesuaikan dengan kebutuhan masing-masing siswa.',
                'kategori_id' => $categories->where('name', 'Pengumuman')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-05 09:15:00'),
                'updated_at' => Carbon::parse('2024-07-05 09:15:00'),
            ],
            [
                'title' => 'Program Pertukaran Pelajar dengan Sekolah Internasional',
                'content' => 'Lemdiklat Taruna Nusantara Indonesia membuka kesempatan program pertukaran pelajar dengan sekolah mitra internasional. Program ini bertujuan untuk memperluas wawasan dan kemampuan berbahasa asing siswa. Kerjasama dilakukan dengan sekolah-sekolah di Singapura, Malaysia, dan Australia dengan durasi program 1 semester.',
                'kategori_id' => $categories->where('name', 'Akademik')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-03 11:45:00'),
                'updated_at' => Carbon::parse('2024-07-03 11:45:00'),
            ],
            [
                'title' => 'Festival Sains dan Teknologi Tingkat Sekolah Menengah',
                'content' => 'Lemdiklat Taruna Nusantara Indonesia akan menjadi tuan rumah Festival Sains dan Teknologi tingkat sekolah menengah se-Jawa Barat. Event ini akan menampilkan berbagai inovasi dan penelitian siswa. Festival berlangsung selama 3 hari dengan berbagai kompetisi seperti science project, robotika, dan innovation showcase.',
                'kategori_id' => $categories->where('name', 'Kegiatan')->first()?->id ?? $categories->first()->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => Carbon::parse('2024-07-01 16:20:00'),
                'updated_at' => Carbon::parse('2024-07-01 16:20:00'),
            ],
        ];

        // Clear existing data first (optional)
        // Berita::truncate();

        foreach ($beritas as $berita) {
            // Buat slug unik berdasarkan title
            $baseSlug = \Illuminate\Support\Str::slug($berita['title']);
            $slug = $baseSlug;
            $counter = 1;

            while (Berita::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            // Masukkan slug secara manual agar tidak ter-overwrite oleh model
            $berita['slug'] = $slug;

            // Gunakan withoutEvents agar Auth::id() tidak overwrite created_by
            Berita::withoutEvents(function () use ($berita) {
                if (!Berita::where('title', $berita['title'])->exists()) {
                    Berita::create($berita);
                }
            });
        }
    }
}