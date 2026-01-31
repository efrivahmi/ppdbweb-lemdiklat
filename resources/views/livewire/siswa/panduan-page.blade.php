<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 200)">
    
    <div class="text-center mb-16 transition-all duration-700 transform"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Panduan Pendaftaran</h1>
        <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Ikuti langkah-langkah mudah berikut untuk menyelesaikan proses pendaftaran Siswa Baru.</p>
    </div>

    <!-- Timeline Container -->
    <div class="space-y-8 relative">
        <!-- Vertical Line (Animated) -->
        <div class="absolute left-6 top-6 bottom-6 w-0.5 bg-gray-200 origin-top transition-transform duration-1000 ease-out delay-500"
             :class="shown ? 'scale-y-100' : 'scale-y-0'"></div>

        @foreach($steps as $index => $step)
        <div class="relative flex gap-6 group transition-all duration-700 transform"
             style="transition-delay: {{ ($index + 1) * 150 }}ms"
             :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
            
            <!-- Icon Bubble -->
            <div class="relative z-10 w-12 h-12 rounded-full flex items-center justify-center border-2 shadow-sm flex-shrink-0 bg-white transition-all duration-300 group-hover:scale-110
                {{ $step['status'] === 'completed' ? 'border-green-500 text-green-600 shadow-green-100' : 
                   ($step['status'] === 'current' ? 'border-blue-500 text-blue-600 ring-4 ring-blue-50 shadow-blue-100 animate-pulse-slow' : 'border-gray-200 text-gray-300') }}">
                
                @if($step['status'] === 'completed')
                    <i class="ri-check-line text-2xl font-bold"></i>
                @else
                    <i class="{{ $step['icon'] }} text-xl"></i>
                @endif
                
                @if($step['status'] === 'completed')
                <div class="absolute -bottom-1 -right-1 bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-sm"
                     title="Selesai">
                    <i class="ri-check-line"></i>
                </div>
                @endif
            </div>

            <!-- Card Content -->
            <div class="flex-1 bg-white p-6 rounded-2xl border transition-all duration-300 hover:shadow-lg
                {{ $step['status'] === 'current' ? 'border-blue-200 shadow-md ring-1 ring-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider 
                                {{ $step['status'] === 'completed' ? 'text-green-600' : ($step['status'] === 'current' ? 'text-blue-600' : 'text-gray-400') }}">
                                Langkah {{ $index + 1 }}
                            </span>
                            @if($step['status'] === 'current')
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold {{ $step['status'] === 'completed' ? 'text-gray-900' : ($step['status'] === 'current' ? 'text-blue-700' : 'text-gray-500') }}">
                            {{ $step['title'] }}
                        </h3>
                        <p class="text-base text-gray-600 mt-2 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>

                    <div class="flex-shrink-0">
                         <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                            {{ $step['status'] === 'completed' ? 'bg-green-100 text-green-700' : 
                               ($step['status'] === 'current' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500') }}">
                             {{ $step['status'] === 'completed' ? 'Selesai' : ($step['status'] === 'current' ? 'Sedang Proses' : 'Tertunda') }}
                         </span>
                    </div>
                </div>

                @if($step['route'])
                <div class="mt-6 pt-4 border-t border-gray-50">
                    <a href="{{ route($step['route']) }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all transform hover:-translate-y-0.5
                        {{ $step['status'] === 'current' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:shadow-lg shadow-blue-200' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                        {{ $step['button'] }}
                        <i class="ri-arrow-right-line ml-2"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
