<section class="py-24 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once="shown = true">
    {{-- Artistic Background --}}
    <div class="absolute inset-0 bg-white">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-bl from-lime-100/40 to-emerald-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 opacity-70"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-lime-50 to-emerald-50 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 opacity-70"></div>
        {{-- Grid Pattern Overlay --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:24px_24px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        {{-- Main Glass Card --}}
        <div class="relative bg-white/60 backdrop-blur-2xl rounded-[3rem] border border-white/50 shadow-2xl overflow-hidden group">
            
            {{-- Decorative accent lines --}}
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-lime-400 to-transparent opacity-50"></div>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-emerald-400 to-transparent opacity-50"></div>

            <div class="grid lg:grid-cols-12 gap-0 relative">
                
                {{-- Left Content (7 Cols) --}}
                <div class="lg:col-span-7 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative z-20">
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-white/80 border border-lime-200/50 rounded-full w-fit mb-8 shadow-sm hover:shadow-md transition-all duration-300 pointer-events-none transform"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 100ms">
                         <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-br from-lime-400 to-emerald-500"></span>
                        </span>
                        <span class="text-sm font-bold uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-lime-600 to-emerald-700">Penerimaan Siswa Baru</span>
                    </div>

                    {{-- Headline --}}
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-zinc-900 mb-8 leading-[1.1] tracking-tight transform transition-all duration-700 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 200ms">
                        Mulai Perjalanan <br>
                        <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-r from-lime-600 via-emerald-600 to-lime-600 animate-gradient-x">
                            Masa Depanmu
                        </span>
                        <br>Di Sini.
                    </h2>

                    {{-- Paragraph --}}
                    <p class="text-lg md:text-xl text-zinc-600 mb-10 leading-relaxed max-w-2xl transform transition-all duration-700 ease-out"
                       :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                       style="transition-delay: 300ms">
                        Bergabunglah dengan komunitas pembelajar di Lemdiklat Taruna Nusantara. Kami mencetak pemimpin berkarakter dengan kurikulum modern dan fasilitas kelas dunia.
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-5 transform transition-all duration-700 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 400ms">
                        
                        <a href="/spmb" 
                           class="group relative px-8 py-4 bg-zinc-900 text-white font-bold text-lg rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-lime-500/20 transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute inset-0 bg-gradient-to-r from-lime-500 to-emerald-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
                            <span class="relative flex items-center gap-3">
                                Daftar Sekarang
                                <x-lucide-arrow-right class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </span>
                        </a>

                        <a href="/panduan" 
                           class="group relative px-8 py-4 bg-white/50 border-2 border-zinc-200 text-zinc-700 font-bold text-lg rounded-2xl hover:bg-white hover:border-lime-200 transition-all duration-300">
                             <span class="relative flex items-center gap-3">
                                <x-lucide-book-open class="w-5 h-5 text-zinc-400 group-hover:text-lime-600 transition-colors" />
                                Panduan Seleksi
                            </span>
                        </a>
                    </div>

                    {{-- Mini Stats Grid (Modern Bento Style) --}}
                    <div class="mt-14 pt-10 border-t border-zinc-200/60 grid grid-cols-2 gap-6 transform transition-all duration-700 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 500ms">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-lime-100 flex items-center justify-center text-lime-600 shadow-inner">
                                <x-lucide-laptop class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-zinc-900 text-lg">Digital</h4>
                                <p class="text-sm text-zinc-500 leading-snug">Sistem seleksi terintegrasi penuh.</p>
                            </div>
                        </div>
                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner">
                                <x-lucide-shield-check class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-zinc-900 text-lg">Transparan</h4>
                                <p class="text-sm text-zinc-500 leading-snug">Hasil seleksi realtime & akurat.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Visual (5 Cols) --}}
                <div class="lg:col-span-5 relative min-h-[500px] lg:min-h-full overflow-hidden bg-zinc-100">
                    {{-- Dynamic Background Image --}}
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center transition-transform duration-[2000ms] ease-out group-hover:scale-110 grayscale-[10%] group-hover:grayscale-0"></div>
                    
                    {{-- Artistic Overlay Gradients --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/80 via-transparent to-zinc-900/20 mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-gradient-to-l from-lime-500/30 to-emerald-500/30 mix-blend-overlay"></div>

                    {{-- Floating Elements --}}
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        {{-- Glass Card Floating --}}
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-3xl transform translate-y-8 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700 ease-out delay-200 max-w-sm ml-auto mr-0 shadow-2xl">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="flex -space-x-3">
                                    <img src="https://i.pravatar.cc/100?img=1" alt="Student" class="w-10 h-10 rounded-full border-2 border-white" />
                                    <img src="https://i.pravatar.cc/100?img=5" alt="Student" class="w-10 h-10 rounded-full border-2 border-white" />
                                    <img src="https://i.pravatar.cc/100?img=8" alt="Student" class="w-10 h-10 rounded-full border-2 border-white" />
                                </div>
                                <span class="text-white font-medium text-sm">+2k Pendaftar</span>
                            </div>
                            <p class="text-white/90 text-sm leading-relaxed">
                                "Bergabung dengan sekolah ini adalah keputusan terbaik untuk masa depan saya."
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
