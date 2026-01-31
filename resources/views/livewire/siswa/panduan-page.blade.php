<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900">Panduan Pendaftaran</h1>
        <p class="mt-2 text-gray-600">Ikuti langkah-langkah berikut untuk menyelesaikan pendaftaran Anda.</p>
    </div>

    <div class="relative">
        <!-- Vertical Line -->
        <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200 md:left-1/2 md:-ml-0.5"></div>

        <div class="space-y-12">
            @foreach($steps as $index => $step)
            <div class="relative flex flex-col md:flex-row gap-8 items-center {{ $loop->even ? 'md:flex-row-reverse' : '' }}">
                
                <!-- Icon/Number -->
                <div class="absolute left-8 -translate-x-1/2 md:left-1/2 md:-translate-x-1/2 z-10 flex items-center justify-center w-16 h-16 rounded-full border-4 shadow-sm transition-colors duration-300
                    {{ $step['status'] === 'completed' ? 'bg-green-100 border-green-500 text-green-600' : 
                       ($step['status'] === 'current' ? 'bg-blue-100 border-blue-500 text-blue-600 animate-pulse' : 'bg-white border-gray-200 text-gray-300') }}">
                    @if($step['status'] === 'completed')
                        <i class="ri-check-line text-2xl font-bold"></i>
                    @else
                        <i class="{{ $step['icon'] }} text-2xl"></i>
                    @endif
                </div>

                <!-- Content LEFT (for odd items on desktop) -->
                <div class="ml-20 md:ml-0 md:w-1/2 md:pr-12 md:text-right {{ $loop->even ? 'md:hidden' : '' }}">
                    <h3 class="text-xl font-bold text-gray-900 {{ $step['status'] === 'current' ? 'text-blue-600' : '' }}">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $step['desc'] }}</p>
                    
                    @if($step['route'])
                    <div class="mt-3">
                        <a href="{{ route($step['route']) }}" class="inline-flex items-center text-sm font-medium {{ $step['status'] === 'completed' ? 'text-green-600' : 'text-blue-600 hover:underline' }}">
                            {{ $step['button'] }} <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Spacer for layout -->
                <div class="hidden md:block md:w-1/2"></div>
                
                <!-- Content RIGHT (for even items on desktop - logic flip needed) -->
                <!-- The logic here is tricky with flex-row-reverse. 
                     If Row Reverse: Right side is actually first in DOM, so we need to be careful.
                     Actually simpler: Just put content in a div and let flex handle it?
                     No, because alignment needs to be right or left.
                -->
                
                <!-- Let's rethink the loop structure for simplicity using grid or absolute positioning for the line -->
            </div>
            @endforeach
        </div>
        
        <!-- Re-implementing with cleaner List Design for reliability -->
        <div class="space-y-8 mt-8 hidden"> <!-- Hiding the complex one above, using simpler one below --> </div>
    </div>

    <!-- Simplified Timeline View -->
    <div class="space-y-8 relative">
        <div class="absolute left-6 top-6 bottom-6 w-0.5 bg-gray-200"></div>

        @foreach($steps as $index => $step)
        <div class="relative flex gap-6 group">
            <!-- Icon -->
            <div class="relative z-10 w-12 h-12 rounded-full flex items-center justify-center border-2 shadow-sm flex-shrink-0 bg-white
                {{ $step['status'] === 'completed' ? 'border-green-500 text-green-600' : 
                   ($step['status'] === 'current' ? 'border-blue-500 text-blue-600 ring-4 ring-blue-50' : 'border-gray-200 text-gray-300') }}">
                <i class="{{ $step['icon'] }} text-xl"></i>
                
                @if($step['status'] === 'completed')
                <div class="absolute -bottom-1 -right-1 bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                    <i class="ri-check-line"></i>
                </div>
                @endif
            </div>

            <!-- Card -->
            <div class="flex-1 bg-white p-5 rounded-xl border {{ $step['status'] === 'current' ? 'border-blue-200 shadow-md transform scale-[1.01]' : 'border-gray-200' }} transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold {{ $step['status'] === 'completed' ? 'text-gray-900' : ($step['status'] === 'current' ? 'text-blue-700' : 'text-gray-500') }}">
                            {{ $index + 1 }}. {{ $step['title'] }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $step['desc'] }}</p>
                    </div>
                    <div>
                         <span class="px-2 py-1 text-xs rounded font-medium
                            {{ $step['status'] === 'completed' ? 'bg-green-100 text-green-700' : 
                               ($step['status'] === 'current' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500') }}">
                             {{ $step['status'] === 'completed' ? 'Selesai' : ($step['status'] === 'current' ? 'Proses' : 'Belum') }}
                         </span>
                    </div>
                </div>

                @if($step['route'])
                <div class="mt-4">
                    <a href="{{ route($step['route']) }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $step['status'] === 'current' ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
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
