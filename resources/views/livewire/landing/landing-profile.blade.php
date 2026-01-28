<div>
    <livewire:components.landing.hero-profile />
    <div class="space-y-16 lg:space-y-18 lg:mx-auto lg:max-w-7xl px-8 lg:px-0 py-16">
        <!-- 2 Cards untuk Profile Pages -->
        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Card SMA -->
            <a href="/profile/sma" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-green-200 hover:border-green-500">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-green-100 p-4 rounded-xl mb-4 group-hover:bg-green-200 transition-colors">
                        <x-heroicon-o-academic-cap class="w-12 h-12 text-green-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Profil SMA</h3>
                    <p class="text-sm text-gray-600">SMA Taruna Nusantara Indonesia</p>
                </div>
            </a>

            <!-- Card SMK -->
            <a href="/profile/smk" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-green-200 hover:border-green-500">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-green-100 p-4 rounded-xl mb-4 group-hover:bg-green-200 transition-colors">
                        <x-heroicon-o-wrench-screwdriver class="w-12 h-12 text-green-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Profil SMK</h3>
                    <p class="text-sm text-gray-600">SMK Taruna Nusantara Jaya</p>
                </div>
            </a>
        </div>

        <livewire:components.landing.sambutan-kepala-sekolah-section />
        <livewire:components.landing.school-section />
        <livewire:components.landing.visi-misi-section />
        <livewire:components.landing.kurikulum-section />
        <div class="pt-30">
            <livewire:components.landing.alumni-section />
        </div>
    </div>
</div>