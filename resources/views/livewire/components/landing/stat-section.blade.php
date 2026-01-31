<section wire:poll.5s>
    <div class="bg-gradient-to-r from-lime-900 to-lime-500 p-7 shadow-xl transition-all duration-300 hover:shadow-2xl hover:bg-lime-600">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-6 md:gap-8">
            @foreach($statsData as $stat)
                <div class="group flex flex-col justify-center items-center w-full" 
                     x-data="{ current: 0, target: {{ preg_replace('/[^0-9]/', '', $stat['value']) }} }" 
                     x-intersect.once="
                        $nextTick(() => {
                            let start = 0;
                            let end = target;
                            let duration = 2000;
                            let range = end - start;
                            let current = start;
                            let increment = end > start ? 1 : -1;
                            let stepTime = Math.abs(Math.floor(duration / range));
                            
                            // Speed up if range is large
                            if (range > 100) stepTime = 20;
                            if (range > 1000) stepTime = 10;
                            
                            let timer = setInterval(() => {
                                current += Math.ceil(range / (duration / 20)); // Increment by a chunk calculated from duration
                                if (current >= end) {
                                    current = end;
                                    clearInterval(timer);
                                }
                                $refs.display.innerText = new Intl.NumberFormat('id-ID').format(current);
                            }, 20);
                        })
                     ">
                    
                    <h2 x-ref="display" class="font-bold text-white group-hover:text-lime-100 transition-colors duration-300 text-3xl lg:text-5xl">
                        0
                    </h2>
                    
                    <x-atoms.description
                        size="sm"
                        class="lg:text-md text-lime-100 text-center"
                    >
                        {{ $stat['label'] }}
                    </x-atoms.description>
                </div>
            @endforeach
        </div>
    </div>
</section>
