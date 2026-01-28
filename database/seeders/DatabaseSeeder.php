<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JalurPendaftaranSeeder::class,
            TipeSekolahSeeder::class,
            JurusanSeeder::class,
            TesJalurSeeder::class,
            AdminDefaultSeeder::class,
            GuruSeeder::class,
            KategoriBeritaSeeder::class,
            BeritaSeeder::class,
            PrestasiSeeder::class,
            ProfileSekolahSeeder::class,
            PersyaratanSeeder::class,
            StrukturSekolahSeeder::class,
            FooterSeeder::class,
            PDFSeeder::class,
            BankAccountSeeder::class,
            VisiMisiSeeder::class,
            EkstrakurikulerSeeder::class,
            KurikulumSeeder::class,
            SambutanKepalaSekolahSeeder::class,
            HeroProfileSeeder::class,
            YoutubeVideoSeeder::class,
        ]);
    }
}
