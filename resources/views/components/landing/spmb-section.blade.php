<section class="py-24 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once="shown = true">
    {{-- Artistic Background --}}
    <div class="absolute inset-0 bg-zinc-50">
        <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-white to-transparent"></div>
        <div class="absolute top-20 right-0 w-[600px] h-[600px] bg-lime-100/40 rounded-full blur-3xl opacity-60 mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-emerald-100/40 rounded-full blur-3xl opacity-60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:24px_24px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            {{-- Left: Information & Announcement --}}
            <div class="relative z-20">
                {{-- Status Badge --}}
                <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/80 backdrop-blur-sm border border-lime-200 rounded-full shadow-sm mb-8 transition-all duration-700 transform"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-lime-500"></span>
                    </span>
                    <span class="text-sm font-bold text-zinc-800 tracking-wide uppercase">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</span>
                </div>

                <h2 class="text-4xl lg:text-5xl font-black text-zinc-900 mb-6 leading-tight tracking-tight transition-all duration-700 delay-100 transform"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Penerimaan Peserta Didik Baru <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-600 to-emerald-600">Sedang Dibuka.</span>
                </h2>

                <p class="text-lg text-zinc-600 mb-10 leading-relaxed max-w-xl transition-all duration-700 delay-200 transform"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Kami mengundang putra-putri terbaik bangsa untuk bergabung. Sebelum melakukan pendaftaran, mohon persiapkan dokumen dan kelengkapan administrasi berikut ini.
                </p>

                {{-- Action Button --}}
                <div class="transition-all duration-700 delay-300 transform"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <a href="/spmb" 
                       class="inline-flex items-center gap-3 px-8 py-4 bg-zinc-900 text-white font-bold rounded-2xl hover:bg-zinc-800 hover:scale-105 hover:shadow-xl hover:shadow-lime-500/20 transition-all duration-300 group">
                        <span>Lanjut ke Formulir SPMB</span>
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center group-hover:bg-lime-500 group-hover:text-zinc-900 transition-colors">
                            <x-lucide-arrow-right class="w-4 h-4" />
                        </div>
                    </a>
                    <p class="mt-4 text-sm text-zinc-500 font-medium flex items-center gap-2">
                        <x-lucide-info class="w-4 h-4 text-lime-600" />
                        Pastikan data yang Anda masukkan sesuai dengan dokumen asli.
                    </p>
                </div>
            </div>

            {{-- Right: Requirements Checklist (Modern Volt Card) --}}
            <div class="relative">
                <div class="relative bg-white/60 backdrop-blur-xl border border-white/50 rounded-[2.5rem] shadow-2xl p-8 lg:p-10 transition-all duration-1000 delay-200 transform hover:shadow-lime-500/10"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-lime-500/30">
                            <x-lucide-clipboard-list class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-zinc-900">Berkas Persyaratan</h3>
                            <p class="text-sm text-zinc-500">Wajib M dibawa/diupload</p>
                        </div>
                    </div>

                    {{-- Checklist Items --}}
                    @php
                        $requirements = [
                            ['icon' => 'user', 'text' => 'Kartu Keluarga (KK) Asli & Fotocopy', 'desc' => 'Terbaru & sudah dilegalisir'],
                            ['icon' => 'file-text', 'text' => 'Akte Kelahiran', 'desc' => 'Pastikan nama sesuai ijazah'],
                            ['icon' => 'graduation-cap', 'text' => 'Ijazah / SKL Terakhir', 'desc' => 'Dari jenjang pendidikan sebelumnya'],
                            ['icon' => 'image', 'text' => 'Pas Foto 3x4 (Warna)', 'desc' => 'Background Merah/Biru (4 Lembar)'],
                            ['icon' => 'activity', 'text' => 'Surat Keterangan Sehat', 'desc' => 'Dari Dokter / Puskesmas'],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($requirements as $index => $req)
                            <div class="group flex items-start gap-4 p-4 bg-white/50 border border-zinc-100 rounded-2xl hover:bg-white hover:border-lime-200 hover:shadow-md transition-all duration-300"
                                 style="transition-delay: {{ 300 + ($index * 100) }}ms"
                                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                                
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-6 h-6 rounded-full border-2 border-lime-500 flex items-center justify-center bg-lime-50 group-hover:bg-lime-500 group-hover:border-lime-500 transition-colors duration-300">
                                        <x-lucide-check class="w-3.5 h-3.5 text-lime-600 group-hover:text-white transition-colors" />
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-zinc-800 text-sm md:text-base group-hover:text-lime-700 transition-colors">{{ $req['text'] }}</h4>
                                    <p class="text-xs text-zinc-400 font-medium mt-0.5">{{ $req['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Bottom Note --}}
                    <div class="mt-8 pt-6 border-t border-dashed border-zinc-200 text-center">
                        <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">
                            Lemdiklat TNI AD
                        </p>
                    </div>
                </div>

                {{-- Decorative Blob --}}
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-lime-300 rounded-full blur-[80px] opacity-40 mix-blend-multiply pointer-events-none"></div>
                 <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-300 rounded-full blur-[80px] opacity-40 mix-blend-multiply pointer-events-none"></div>
            </div>

        </div>
    </div>
</section>
