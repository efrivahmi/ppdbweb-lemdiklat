<section class=" lg:mx-auto lg:max-w-7xl lg:px-0 relative overflow-hidden rounded-xl lg:rounded-3xl mt-6 lg:mt-13">
    <!-- Background Gradients -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-lime-700 to-lime-500"></div>
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/camouflage.png')]"></div>
    
    <div class="max-w-7xl mx-auto px-3 md:px-6 py-6 md:py-12 relative z-10">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center gap-3 md:gap-6 mb-6 md:mb-12">
            <img src="{{ asset('assets/logo.png') }}"
                 alt="Logo"
                 class="w-24 h-24 md:w-32 md:h-32 lg:w-48 lg:h-48 object-contain">
            
            <div class="text-center lg:text-left">
                <h2 class="text-xl md:text-3xl lg:text-5xl font-extrabold tracking-tight mb-2 md:mb-4 leading-tight">
                    <span class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                        Visi & Misi
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-amber-300 bg-clip-text text-transparent">
                        Lemdiklat Taruna Nusantara Indonesia
                    </span>
                </h2>
                <p class="text-xs md:text-base lg:text-lg text-gray-300 max-w-2xl leading-relaxed">
                    Mencetak generasi yang <span class="text-yellow-400 font-bold">berakhlak mulia, cerdas, dan terampil</span> untuk masa depan Indonesia yang lebih baik.
                </p>
            </div>
        </div>

        <div class="space-y-4 md:space-y-8">
            <!-- VISI Section -->
            <div class="bg-white/5 backdrop-blur-sm rounded-lg md:rounded-2xl p-4 md:p-8 shadow-md hover:bg-white/10 transition-all duration-300">
                <!-- Visi Header -->
                <div class="flex items-center gap-2 md:gap-4 mb-3 md:mb-6">
                    <div class="w-9 h-9 md:w-12 md:h-12 flex-shrink-0 rounded-lg md:rounded-xl bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 md:w-6 md:h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-2xl lg:text-3xl font-bold text-yellow-400">
                        {{ $visiData['title'] }}
                    </h3>
                </div>

                <!-- Visi Content -->
                <p class="text-gray-200 text-xs md:text-base lg:text-lg leading-relaxed mb-4 md:mb-8">
                    {{ $visiData['content'] }}
                </p>

                <!-- Divider -->
                <div class="h-px bg-gradient-to-r from-transparent via-white/30 to-transparent mb-4 md:mb-8"></div>

                <!-- Visi Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                    @foreach($visiData['items'] as $index => $item)
                        <div class="flex items-start gap-2 md:gap-4 bg-white/5 rounded-lg md:rounded-xl p-3 md:p-4 hover:bg-white/10 transition-all duration-300">
                            <!-- Number Badge -->
                            <div class="w-7 h-7 md:w-10 md:h-10 flex-shrink-0 rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-900 font-bold text-xs md:text-base flex items-center justify-center shadow-md">
                                {{ $index + 1 }}
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-xs md:text-base mb-1 leading-tight">
                                    {{ $item['title'] }}
                                </h4>
                                <p class="text-gray-300 text-[10px] md:text-sm leading-relaxed">
                                    {{ $item['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MISI Section -->
            <div class="bg-white/5 backdrop-blur-sm rounded-lg md:rounded-2xl p-4 md:p-8 shadow-md hover:bg-white/10 transition-all duration-300">
                <!-- Misi Header -->
                <div class="flex items-center gap-2 md:gap-4 mb-3 md:mb-6">
                    <div class="w-9 h-9 md:w-12 md:h-12 flex-shrink-0 rounded-lg md:rounded-xl bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 md:w-6 md:h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-2xl lg:text-3xl font-bold text-yellow-400">
                        {{ $misiData['title'] }}
                    </h3>
                </div>

                <!-- Misi Content -->
                <p class="text-gray-200 text-xs md:text-base lg:text-lg leading-relaxed mb-4 md:mb-8">
                    {{ $misiData['content'] }}
                </p>

                <!-- Divider -->
                <div class="h-px bg-gradient-to-r from-transparent via-white/30 to-transparent mb-4 md:mb-8"></div>

                <!-- Misi Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                    @foreach($misiData['items'] as $index => $misi)
                        <div class="flex items-start gap-2 md:gap-4 bg-white/5 rounded-lg md:rounded-xl p-3 md:p-4 hover:bg-white/10 transition-all duration-300">
                            <!-- Number Badge -->
                            <div class="w-7 h-7 md:w-10 md:h-10 flex-shrink-0 rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-900 font-bold text-xs md:text-base flex items-center justify-center shadow-md">
                                {{ $index + 1 }}
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-xs md:text-base mb-1 leading-tight">
                                    {{ $misi['title'] }}
                                </h4>
                                <p class="text-gray-300 text-[10px] md:text-sm leading-relaxed">
                                    {{ $misi['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>