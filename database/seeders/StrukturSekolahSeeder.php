<?php

namespace Database\Seeders;

use App\Models\Landing\StrukturSekolah;
use Illuminate\Database\Seeder;

class StrukturSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strukturData = [
            [
                'nama' => 'Dr. Ahmad Suryono, M.Pd',
                'desc' => 'Memimpin dan mengelola seluruh kegiatan sekolah dengan visi mencerdaskan bangsa melalui pendidikan berkualitas.',
                'jabatan' => 'Kepala Sekolah',
                'posisi' => 1,
                'img' => null,
            ],
            [
                'nama' => 'Siti Nurhaliza, S.Pd, M.M',
                'desc' => 'Mengkoordinasikan dan mengawasi kegiatan akademik serta pengembangan kurikulum sekolah.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Akademik',
                'posisi' => 2,
                'img' => null,
            ],
            [
                'nama' => 'Budi Santoso, S.Pd',
                'desc' => 'Mengelola dan membina karakter siswa melalui berbagai program kesiswaan dan ekstrakurikuler.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'posisi' => 3,
                'img' => null,
            ],
            [
                'nama' => 'Ratna Sari, S.E',
                'desc' => 'Bertanggung jawab atas pengelolaan sarana prasarana dan infrastruktur sekolah.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Sarana Prasarana',
                'posisi' => 4,
                'img' => null,
            ],
            [
                'nama' => 'Indra Wijaya, S.Kom',
                'desc' => 'Mengelola hubungan sekolah dengan masyarakat dan kemitraan industri.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Humas',
                'posisi' => 5,
                'img' => null,
            ],
            [
                'nama' => 'Prof. Dr. Suharno, M.Si',
                'desc' => 'Guru senior dengan pengalaman mengajar matematika lebih dari 25 tahun.',
                'jabatan' => 'Guru Matematika',
                'posisi' => 6,
                'img' => null,
            ],
            [
                'nama' => 'Dewi Kartika, S.S, M.Pd',
                'desc' => 'Mengajar bahasa Indonesia dan membina kegiatan literasi sekolah.',
                'jabatan' => 'Guru Bahasa Indonesia',
                'posisi' => 7,
                'img' => null,
            ],
            [
                'nama' => 'John Smith, S.Pd',
                'desc' => 'Native speaker yang mengajar bahasa Inggris dan program bilingual.',
                'jabatan' => 'Guru Bahasa Inggris',
                'posisi' => 8,
                'img' => null,
            ],
            [
                'nama' => 'Dr. Fitri Handayani, M.Si',
                'desc' => 'Mengajar biologi dan mengelola laboratorium sains sekolah.',
                'jabatan' => 'Guru Biologi',
                'posisi' => 9,
                'img' => null,
            ],
            [
                'nama' => 'Agus Setiawan, S.Pd',
                'desc' => 'Mengajar pendidikan jasmani dan melatih tim olahraga sekolah.',
                'jabatan' => 'Guru Pendidikan Jasmani',
                'posisi' => 10,
                'img' => null,
            ],
            [
                'nama' => 'Maya Sari, S.Pd',
                'desc' => 'Memberikan layanan konseling dan bimbingan kepada siswa.',
                'jabatan' => 'Guru BK (Bimbingan Konseling)',
                'posisi' => 11,
                'img' => null,
            ],
            [
                'nama' => 'Rina Astuti, S.Sos',
                'desc' => 'Mengelola administrasi sekolah dan dokumentasi akademik.',
                'jabatan' => 'Tenaga Administrasi',
                'posisi' => 12,
                'img' => null,
            ],
        ];

        foreach ($strukturData as $data) {
            StrukturSekolah::create($data);
        }
    }
}