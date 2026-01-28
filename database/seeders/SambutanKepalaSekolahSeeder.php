<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\SambutanKepalaSekolah;

class SambutanKepalaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SambutanKepalaSekolah::truncate();

        SambutanKepalaSekolah::create([
            // Badge
            'badge_text' => 'Sambutan',
            'badge_variant' => 'indigo',
            'badge_size' => 'md',

            // Title
            'title_text' => 'Sambutan Kepala SMA Taruna Nusantara Indonesia',
            'title_highlight' => 'Sambutan Kepala',
            'title_size' => '3xl',
            'title_class_name' => 'lg:text-5xl',

            // Principal
            'principal_name' => 'Dr. Oyib Ferdiansyah, M.Pd.',
            'principal_title' => 'Kepala SMA Taruna Nusantara Indonesia',
            'principal_image' => 'https://images.unsplash.com/photo-1581092334504-22d879d7f5e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
            'principal_signature' => null,

            // Greeting
            'greeting_opening' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh,',
            'greeting_paragraphs' => [
                'Puji syukur ke hadirat Allah SWT atas segala rahmat dan karunia-Nya sehingga kita semua dapat terus berjuang dalam menjalankan amanah pendidikan di SMA Taruna Nusantara Indonesia.',
                'Sekolah ini lahir dari tekad besar untuk mencetak generasi muda yang beriman, berdisiplin, dan berjiwa kepemimpinan melalui perpaduan antara pendidikan formal, ketarunaan, dan pembinaan kepesantrenan. Kami meyakini bahwa masa depan bangsa ditentukan oleh karakter dan integritas generasi mudanya. Oleh karena itu, kami berkomitmen membangun sistem pendidikan yang tidak hanya mengasah kecerdasan intelektual, tetapi juga menanamkan nilai moral, spiritual, dan nasionalisme yang kokoh.',
                'Pendidikan ketarunaan di sekolah ini melatih peserta didik agar memiliki disiplin, tanggung jawab, dan rasa cinta tanah air, sedangkan sistem kepesantrenan menumbuhkan iman, adab, dan akhlak mulia dalam kehidupan sehari-hari. Keduanya bersatu dalam semangat untuk membentuk insan yang cerdas, tangguh, dan berjiwa pemimpin yang berkarakter santri.',
                'Kami percaya bahwa lulusan SMA Taruna Nusantara Indonesia akan tumbuh menjadi pribadi yang mandiri, berdaya saing, serta siap mengabdi bagi agama, bangsa, dan negara.',
                'Terima kasih kepada seluruh guru, tenaga kependidikan, orang tua, serta seluruh Taruna-Santri yang senantiasa berjuang bersama dalam mewujudkan visi besar sekolah ini.',
                'Mari kita terus melangkah dengan semangat, disiplin, dan keikhlasan — karena dari sinilah lahir generasi “Beriman dalam Jiwa, Berdisiplin dalam Tindakan, dan Berbakti untuk Bangsa.”',
            ],
            'greeting_closing' => 'Wassalamu’alaikum Warahmatullahi Wabarakatuh.',

            // Quote
            'quote_text' => 'Beriman dalam Jiwa, Berdisiplin dalam Tindakan, dan Berbakti untuk Bangsa.',
            'quote_author' => 'Dr. Oyib Ferdiansyah, M.Pd.',

            // Status
            'is_active' => true,
        ]);
    }
}
