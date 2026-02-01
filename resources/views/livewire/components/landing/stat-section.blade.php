<section>
    <div class="bg-gradient-to-r from-lime-900 to-lime-500 p-7 shadow-xl transition-all duration-300 hover:shadow-2xl hover:bg-lime-600">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-6 md:gap-8">
            @foreach($statsData as $stat)
                @php
                    // Check if the label implies a year (e.g. "Tahun Berdiri")
                    $isYear = Str::contains(strtolower($stat['label']), 'tahun');
                    // Extract numbers for the counter target if it's NOT a year
                    $numericValue = $isYear ? $stat['value'] : preg_replace('/[^0-9]/', '', $stat['value']);
                @endphp

                <div class="group flex flex-col justify-center items-center w-full" 
                     @if(!$isYear)
                         {{-- Only attach Alpine counting logic if it is NOT a year --}}
                         x-data="{ current: 0, target: {{ $numericValue }} }" 
                         x-intersect.once="
                            $nextTick(() => {
                                let start = 0;
                                let end = target;
                                let duration = 2000;
                                let range = end - start;
                                let current = start;
                                let stepTime = Math.abs(Math.floor(duration / range));
                                
                                if (range > 100) stepTime = 20;
                                if (range > 1000) stepTime = 10;
                                
                                let timer = setInterval(() => {
                                    current += Math.ceil(range / (duration / 20));
                                    if (current >= end) {
                                        current = end;
                                        clearInterval(timer);
                                    }
                                    $refs.display.innerText = new Intl.NumberFormat('id-ID').format(current);
                                }, 20);
                            })
                         "
                     @else
                         {{-- Simple Fade In via Alpine for Year --}}
                         x-data="{ shown: false }"
                         x-intersect.once="shown = true"
                     @endif
                     >
                    
                    <h2 @if(!$isYear) x-ref="display" @endif 
                        class="font-bold text-white group-hover:text-lime-100 transition-all duration-700 text-3xl lg:text-5xl"
                        @if($isYear)
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                        @endif
                        >
                        {{-- Force Year to be string without dots (e.g. 2012, not 2.012) --}}
                        {{ $isYear ? str_replace('.', '', $stat['value']) : '0' }}
                    </h2>
                    
                    <x-atoms.description
                        size="sm"
                        color="lime-100"
                        class="lg:text-md text-center"
                    >
                        {{ $stat['label'] }}
                    </x-atoms.description>
                </div>
            @endforeach
        </div>
    </div>
</section>
