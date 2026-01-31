<section class="py-16 md:py-24 bg-zinc-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            {{-- Text Content --}}
            <div class="order-2 lg:order-1">
                <x-atoms.badge
                    text="Lokasi Kami"
                    variant="zinc"
                    size="sm"
                    class="mb-4" />
                
                <x-atoms.title
                    text="Kunjungi Sekolah Kami"
                    highlight="Kampus Hijau"
                    size="3xl"
                    mdSize="4xl"
                    class="text-zinc-900 mb-6" />

                <x-atoms.description
                    size="md"
                    class="text-zinc-600 mb-8 leading-relaxed">
                    Terletak di lingkungan yang asri dan strategis, kampus kami memberikan suasana belajar yang kondusif. Datang dan rasakan sendiri atmosfer pendidikan yang inspiratif.
                </x-atoms.description>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-white rounded-xl shadow-sm border border-zinc-100 shrink-0 text-lime-600">
                           <x-heroicon-o-map-pin class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 mb-1">Alamat Lengkap</h4>
                            <p class="text-sm text-zinc-600 leading-relaxed">Jl. Raya Cibubur - Cileungsi No.KM. 12, Ciangsana, Kec. Gn. Putri<br>Kabupaten Bogor, Jawa Barat 16968</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                         <div class="p-3 bg-white rounded-xl shadow-sm border border-zinc-100 shrink-0 text-lime-600">
                           <x-heroicon-o-phone class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 mb-1">Kontak Informasi</h4>
                             <p class="text-sm text-zinc-600 leading-relaxed">Telepon: (021) 1234-5678<br>Email: info@lemdiklat-tni.sch.id</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                         <div class="p-3 bg-white rounded-xl shadow-sm border border-zinc-100 shrink-0 text-lime-600">
                           <x-heroicon-o-clock class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 mb-1">Jam Operasional</h4>
                             <p class="text-sm text-zinc-600 leading-relaxed">Senin - Jumat: 07.00 - 15.00 WIB<br>Sabtu: 07.00 - 12.00 WIB</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                     <x-atoms.button
                        variant="primary"
                        theme="light"
                        size="md"
                        rounded="lg"
                        iconPosition="right"
                        onclick="window.open('https://maps.google.com', '_blank')">
                        Buka Google Maps
                        <x-heroicon-m-arrow-up-right class="w-4 h-4 ml-2" />
                    </x-atoms.button>
                </div>
            </div>

            {{-- Map/Image Visual --}}
            <div class="order-1 lg:order-2 h-96 lg:h-[500px] bg-white rounded-3xl shadow-xl border border-zinc-100 overflow-hidden relative group">
                {{-- Placeholder Map Image or Iframe --}}
                 <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15859.458066601448!2d106.94276705!3d-6.4116279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69950d8705f13d%3A0xc3c544bd06b38c22!2sKota%20Wisata%20Cibubur!5e0!3m2!1sid!2sid!4v1707996395998!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-full grayscale group-hover:grayscale-0 transition-all duration-700 ease-in-out">
                </iframe>
                
                {{-- Overlay text if needed --}}
                <div class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-md p-4 rounded-xl border border-zinc-200 shadow-sm md:hidden">
                    <p class="text-xs font-semibold text-zinc-900 text-center">Tap peta untuk interaksi</p>
                </div>
            </div>
        </div>
    </div>
</section>
