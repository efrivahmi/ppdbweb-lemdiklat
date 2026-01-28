<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\PDF;

class PDFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PDF Verifikasi
        PDF::updateOrCreate(
            ['jenis' => 'verifikasi'],
            [
                'nama_sekolah' => 'SMA TARUNA NUSANTARA INDONESIA',
                'alamat_sekolah' => 'Jl. Raya Purwakarta Kp. Warga Saluyu Rt.01/15 Desa. Cisomang Barat',
                'kecamatan' => 'Cikalongwetan',
                'kabupaten' => 'Kab. Bandung Barat',
                'provinsi' => 'Provinsi Jawa Barat',
                'kode_pos' => '40556',
                'email' => 'lemdiktarunanusantaraindonesia@gmail.com',
                'telepon' => '022-86866083',
                'website' => 'www.lemdiktarunanusantaraindonesia.sch.id',
                'judul_pdf' => 'TANDA BUKTI VERIFIKASI PENDAFTARAN PENERIMAAN SISWA BARU',
                'pesan_penting' => 'Untuk mendapatkan ID Password Test Akademik segera lakukan pembayaran Registrasi paling lambat 2 hari setelah mendaftar, ke nomor rekening BNI 2212801280 a/n SMA Taruna Nusantara Indonesia dan konfirmasi bukti transfer ke nomor Whatsapp 0821-1622-4997 a/n ibu Qori',
                'nama_operator' => 'Agung Iman Setiawan',
                'jabatan_operator' => 'Operator PPDB',
                'catatan_tambahan' => 'Pembayaran Registrasi tidak dapat dikembalikan.',
                'is_active' => true,
            ]
        );

        // PDF Penerimaan
        PDF::updateOrCreate(
            ['jenis' => 'penerimaan'],
            [
                'nama_sekolah' => 'SMA TARUNA NUSANTARA INDONESIA',
                'alamat_sekolah' => 'Jl. Raya Purwakarta Kp. Warga Saluyu Rt.01/15 Desa. Cisomang Barat',
                'kecamatan' => 'Cikalongwetan',
                'kabupaten' => 'Kab. Bandung Barat',
                'provinsi' => 'Provinsi Jawa Barat',
                'kode_pos' => '40556',
                'email' => 'lemdiktarunanusantaraindonesia@gmail.com',
                'telepon' => '022-86866083',
                'website' => 'www.lemdiktarunanusantaraindonesia.sch.id',
                'judul_pdf' => 'SURAT PENERIMAAN SISWA BARU',
                'pesan_penting' => 'Selamat! Anda telah diterima sebagai siswa baru. Silakan melakukan daftar ulang sesuai jadwal yang telah ditentukan.',
                'nama_operator' => 'Agung Iman Setiawan',
                'jabatan_operator' => 'Operator PPDB',
                'catatan_tambahan' => 'Harap membawa dokumen asli saat daftar ulang. Jadwal daftar ulang akan diberitahukan melalui email atau WhatsApp.',
                'is_active' => true,
            ]
        );
    }
}