<div>
    <x-atoms.breadcrumb currentPath="PPDB Ditutup" />

    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
            <x-lucide-lock class="w-12 h-12 text-red-600" />
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Sedang Ditutup</h1>
        
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            Mohon maaf, sistem Penerimaan Peserta Didik Baru (PPDB) saat ini sedang ditutup. 
            Silakan pantau informasi pendaftaran melalui halaman utama atau sosial media resmi kami.
        </p>

        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-colors bg-lime-600 rounded-lg hover:bg-lime-700">
            <x-lucide-home class="w-4 h-4" />
            Kembali ke Beranda
        </a>
    </div>
</div>
