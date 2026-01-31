<?php

use App\Livewire\Admin\Admin\DataAdmin;
use App\Livewire\Admin\Admin\DetailAdmin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Landing\AboutPage;
use App\Livewire\Admin\Landing\BeritaPage;
use App\Livewire\Admin\Landing\FasilitasPage;
use App\Livewire\Admin\Landing\FooterPage;
use App\Livewire\Admin\Landing\HeroProfileSection;
use App\Livewire\Admin\Landing\HeroSpmbSection;
use App\Livewire\Admin\Landing\KategoriBeritaPage;
use App\Livewire\Admin\Landing\LinkYoutubeSection;
use App\Livewire\Admin\Landing\PersyaratanPage;
use App\Livewire\Admin\Landing\PrestasiPage;
use App\Livewire\Admin\Landing\ProfileSekolahPage;
// use App\Livewire\Admin\Landing\StrukturSekolahPage;
use App\Livewire\Admin\Landing\VisiMisiPage;
use App\Livewire\Admin\Landing\AlumniSection;
use App\Livewire\Admin\Landing\EkstrakurikulerPage;
use App\Livewire\Admin\Landing\EncourageSection;
use App\Livewire\Admin\Landing\GallerySection;
use App\Livewire\Admin\Landing\InformationSection;
use App\Livewire\Admin\Landing\KurikulumPage;
use App\Livewire\Admin\Landing\KurikulumSection;
use App\Livewire\Admin\Landing\LinkPhotoSection;
use App\Livewire\Admin\Pembayaran\BuktiTransferPage;
use App\Livewire\Admin\Pendaftaran\BankAccountPage;
use App\Livewire\Admin\Pendaftaran\JalurPendaftaranPage;
use App\Livewire\Admin\Pendaftaran\TesJalurPage;
use App\Livewire\Admin\Pendaftaran\TipeSekolahPage;
use App\Livewire\Admin\Siswa\DataSiswa;
use App\Livewire\Admin\Siswa\DetailSiswa;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Landing\Pages\News;
use App\Livewire\Landing\Pages\ProfileSma;
use App\Livewire\Landing\Pages\ProfileSmk;
use App\Livewire\Landing\LandingProfile;
use App\Livewire\Landing\Spmb;
use App\Livewire\Siswa\Dashboard;
use App\Livewire\Siswa\Profile;
use App\Livewire\Siswa\Formulir\DataMuridPage;
use App\Livewire\Siswa\Formulir\DataOrangTuaPage;
use App\Livewire\Siswa\Formulir\BerkasMuridPage;
use App\Livewire\Siswa\Formulir\FormulirPendaftaranPage;
use App\Livewire\Siswa\InformasiTes;
use App\Livewire\Landing\Landing;
use App\Livewire\Landing\Pages\Achievement;
use App\Livewire\Landing\Pages\Facility;
use App\Livewire\Landing\Pages\Requirement;
// use App\Livewire\Landing\Pages\Structure;
use App\Livewire\Landing\Pages\Alumni;
use App\Livewire\Landing\Pages\Ekstrakurikuler;
use Illuminate\Support\Facades\Route;

Route::get('/', Landing::class)->name('landing');
Route::get('/spmb', Spmb::class)->name('spmb');
Route::get('/profile', LandingProfile::class)->name('profile');
Route::get('/profile/sma', ProfileSma::class)->name('profile.sma');
Route::get('/profile/smk', ProfileSmk::class)->name('profile.smk');
Route::get('/news', News::class)->name('news');
Route::get('/achievement', Achievement::class)->name('achievement');
Route::get('/facility', Facility::class)->name('facility');
Route::get('/requirement', Requirement::class)->name('requirement');
// Route::get('/structure', Structure::class)->name('structure');
Route::get('/alumni', Alumni::class)->name('alumni');
Route::get('/ekstrakurikuler', App\Livewire\Landing\Pages\Ekstrakurikuler::class)->name('ekstrakurikuler');

Route::get('/register', RegisterPage::class)->name('register');
Route::get('/login', LoginPage::class)->name('login');

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::prefix('siswa')
    ->middleware(['auth', 'isSiswa'])
    ->group(function () {
        // Dashboard & Profil
        Route::get('/', action: Dashboard::class)->name('siswa.dashboard');
        Route::get('/profile', Profile::class)->name('siswa.profile');

        // Formulir
        Route::prefix('formulir')->group(function () {
            Route::get('/data-murid', DataMuridPage::class)->name('siswa.formulir.data-murid');
            Route::get('/data-orang-tua', DataOrangTuaPage::class)->name('siswa.formulir.data-orang-tua');
            Route::get('/berkas-murid', BerkasMuridPage::class)->name('siswa.formulir.berkas-murid');
        });

        Route::get('/tests', App\Livewire\Siswa\AvailableTestsPage::class)->name('siswa.tests.index');
        Route::get('/test/{testId}', App\Livewire\Siswa\TestTakingPage::class)->name('siswa.test.take');

        // Pendaftaran & Informasi
        Route::get('/pendaftaran', FormulirPendaftaranPage::class)->name('siswa.pendaftaran');
        Route::get('/informasi-tes', InformasiTes::class)->name('siswa.informasi-tes');
        Route::get('/status-penerimaan', App\Livewire\Siswa\StatusPenerimaan::class)->name('siswa.status-penerimaan')->middleware('checkHariPengumuman');

        // PDF Downloads untuk Siswa
        Route::prefix('pdf')->group(function () {
            Route::get('/verifikasi', [App\Http\Controllers\PDFController::class, 'generateMyVerifikasiPDF'])->name('siswa.pdf.verifikasi');
            Route::get('/penerimaan', [App\Http\Controllers\PDFController::class, 'generateMyPenerimaanPDF'])->name('siswa.pdf.penerimaan');
        });
    });


// Admin Routes
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/profile', \App\Livewire\Admin\ProfileAdmin::class)->name('admin.profile');
    // Siswa
    Route::get('/siswa', DataSiswa::class)->name('admin.siswa');
    Route::get('/siswa/{id}', DetailSiswa::class)->name('admin.siswa.detail');

    // Admin
    Route::get('/admin', DataAdmin::class)->name('admin.admin');
    Route::get('/admin/{id}', DetailAdmin::class)->name('admin.admin.detail');

    // Guru
    Route::get('/guru', App\Livewire\Admin\Guru\DataGuru::class)->name('admin.guru');
    Route::get('/guru/{id}', App\Livewire\Admin\Guru\DetailGuru::class)->name('admin.guru.detail');
    Route::get("/mapel", App\Livewire\Admin\Guru\MapelPage::class)->name("admin.guru.mapel");

    // Pendaftaran 
    Route::get('/pendaftaran/jalur-pendaftaran', JalurPendaftaranPage::class)->name('admin.pendaftaran.jalur');
    Route::get('/pendaftaran/tipe-sekolah', TipeSekolahPage::class)->name('admin.pendaftaran.tipe');
    Route::get('/pendaftaran/tes-jalur', TesJalurPage::class)->name('admin.pendaftaran.tes-jalur');
    Route::get('pendaftaran/custom-test', App\Livewire\Admin\Pendaftaran\CustomTestPage::class)->name('admin.pendaftaran.custom-test');
    Route::get('/review-answers', App\Livewire\Admin\Pendaftaran\ReviewAnswersPage::class)->name('admin.review-answers');
    Route::get("/pendaftaran/gelombang", App\Livewire\Admin\Pendaftaran\GelombangPendaftaranPage::class)->name('admin.pendaftaran.gelombang');
    Route::get('/pendaftaran/jadwal-ujian-khusus', App\Livewire\Admin\Pendaftaran\JadwalUjianKhususPage::class)->name('admin.pendaftaran.jadwal-ujian-khusus');

    // Pembayaran
    Route::get('/pembayaran/bukti-transfer', BuktiTransferPage::class)->name('admin.pembayaran.bukti-transfer');
    Route::get('/pembayaran/bank-account', BankAccountPage::class)->name('admin.pembayaran.bank-account');
    // LandingPage
    Route::get('/landing/profile-sekolah', ProfileSekolahPage::class)->name('admin.landing.profile-sekolah');
    Route::get('/landing/visi-misi', VisiMisiPage::class)->name('admin.landing.visi-misi');
    Route::get('/landing/about', AboutPage::class)->name('admin.landing.about');
    Route::get('/landing/kategori-berita', KategoriBeritaPage::class)->name('admin.landing.kategori-berita');
    Route::get('/landing/berita', BeritaPage::class)->name('admin.landing.berita');
    Route::get('/landing/priority-news', App\Livewire\Admin\Landing\PriorityNewsPage::class)->name('admin.landing.priority-news');
    Route::get('/landing/footer', FooterPage::class)->name('admin.landing.footer');
    Route::get('/landing/prestasi', PrestasiPage::class)->name('admin.landing.prestasi');
    Route::get('/landing/fasilitas', FasilitasPage::class)->name('admin.landing.fasilitas');
    Route::get('/landing/persyaratan', PersyaratanPage::class)->name('admin.landing.persyaratan');
    // Route::get('/landing/struktur-sekolah', StrukturSekolahPage::class)->name('admin.landing.struktur-sekolah');
    Route::get('/landing/pdf-settings', App\Livewire\Admin\Landing\PDFSettingsPage::class)->name('admin.landing.pdf-settings');
    Route::get('/landing/stats-section', App\Livewire\Admin\Landing\StatSection::class)->name('admin.landing.stats-section');
    Route::get('/landing/alumni', App\Livewire\Admin\Landing\AlumniSection::class)->name('admin.landing.alumni');
    Route::get('/landing/ekstrakurikuler', EkstrakurikulerPage::class)->name('admin.landing.ekstrakurikuler');
    Route::get('/landing/kurikulum', KurikulumSection::class)->name('admin.landing.kurikulum');
    Route::get('/landing/encourage', EncourageSection::class)->name('admin.landing.encourage');
    Route::get('/landing/information', InformationSection::class)->name('admin.landing.information');
    Route::get('/landing/hero-profile', HeroprofileSection::class)->name('admin.landing.hero-profile');
    Route::get('/landing/hero-spmb', HeroSpmbSection::class)->name('admin.landing.hero-spmb');
    Route::get('/landing/link-photo', LinkPhotoSection::class)->name('admin.landing.link-photo');
    Route::get('/landing/gallery', GallerySection::class)->name('admin.landing.gallery');
    Route::get('/landing/link-youtube', LinkYoutubeSection::class)->name('admin.landing.link-youtube');
    
    // Settings
    Route::get('/settings/school', App\Livewire\Admin\Settings\SchoolSettingsPage::class)->name('admin.settings.school');
    
    // Profile Sekolah (SMA & SMK)
    Route::get('/profile-sekolah/sma', App\Livewire\Admin\ProfileSekolah\SmaPage::class)->name('admin.profile-sekolah.sma');
    Route::get('/profile-sekolah/smk', App\Livewire\Admin\ProfileSekolah\SmkPage::class)->name('admin.profile-sekolah.smk');
    
    // PDF Routes
    Route::prefix('pdf')->group(function () {
        Route::get('/verifikasi/{userId}', [App\Http\Controllers\PDFController::class, 'generateVerifikasiPDF'])->name('admin.pdf.verifikasi');
        Route::get('/penerimaan/{userId}', [App\Http\Controllers\PDFController::class, 'generatePenerimaanPDF'])->name('admin.pdf.penerimaan');
        Route::get('/preview/verifikasi/{userId}', [App\Http\Controllers\PDFController::class, 'previewVerifikasiPDF'])->name('admin.pdf.preview.verifikasi');
        Route::get('/preview/penerimaan/{userId}', [App\Http\Controllers\PDFController::class, 'previewPenerimaanPDF'])->name('admin.pdf.preview.penerimaan');
    });
});

Route::prefix('guru')->middleware(['auth', 'isGuru'])->group(function () {
    Route::get('/', App\Livewire\Guru\Dashboard::class)->name('guru.dashboard');
    Route::get('/profile', App\Livewire\Guru\ProfileGuru::class)->name('guru.profile');

    // Siswa
    // Route::get('/siswa', App\Livewire\Guru\Siswa\DataSiswa::class)->name('guru.siswa');
    // Route::get('/siswa/{id}', App\Livewire\Guru\Siswa\DetailSiswa::class)->name('guru.siswa.detail');


    // Pendaftaran
    Route::get('/pendaftaran/tes-jalur', App\Livewire\Guru\Pendaftaran\TesJalurPage::class)->name('guru.pendaftaran.tes-jalur')
    ->middleware('guruAccess:manage-custom-test');
    Route::get('/pendaftaran/custom-test', App\Livewire\Guru\Pendaftaran\CustomTestPage::class)
        ->middleware('guruAccess:manage-custom-test')
        ->name('guru.pendaftaran.custom-test');
    Route::get('/pendaftaran/review-answers', App\Livewire\Guru\Pendaftaran\ReviewAnswersPage::class)
        ->middleware('guruAccess:manage-custom-test')
        ->name('guru.review-answers');
});


// Sitemap
use App\Models\Landing\Berita;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();
    
    // Landing pages statis
    $pages = [
        ['url' => '/', 'priority' => 1.0],
        ['url' => '/spmb', 'priority' => 0.9],
        ['url' => '/profile', 'priority' => 0.9],
        ['url' => '/news', 'priority' => 0.9],
        ['url' => '/achievement', 'priority' => 0.8],
        ['url' => '/facility', 'priority' => 0.8],
        ['url' => '/requirement', 'priority' => 0.8],
        ['url' => '/structure', 'priority' => 0.8],
        ['url' => '/alumni', 'priority' => 0.8],
        ['url' => '/ekstrakurikuler', 'priority' => 0.8],
    ];
    
    foreach ($pages as $page) {
        $sitemap->add(Url::create($page['url'])
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority($page['priority']));
    }
    
    // Dynamic berita pages
    Berita::where('is_active', true)->get()->each(function ($berita) use ($sitemap) {
        $sitemap->add(
            Url::create("/news/{$berita->slug}")
                ->setLastModificationDate($berita->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );
    });
    
    $sitemap->writeToFile(public_path('sitemap.xml'));
    
    return response('Sitemap generated!', 200)->header('Content-Type', 'text/plain');
});