<section wire:poll.5s>
    <div class="bg-gradient-to-r from-lime-900 to-lime-500 p-7 shadow-xl transition-all duration-300 hover:shadow-2xl hover:bg-lime-600">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-6 md:gap-8">
            @foreach($statsData as $stat)
                <div class="group flex flex-col justify-center items-center w-full">
                    <x-atoms.title
                        :text="$stat['value']"
                        size="xl"
                        class="text-white group-hover:text-lime-100 transition-colors duration-300 lg:text-5xl"
                    />
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
