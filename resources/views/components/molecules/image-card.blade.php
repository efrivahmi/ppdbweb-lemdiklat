@props([
    'imageUrl' => '',
    'desc' => '',
    'title' => '',
    'alt' => 'Image',
])

<div class="relative rounded-2xl overflow-hidden shadow-xl">
    <div class="aspect-video rounded-2xl overflow-hidden">
        <img
            src="{{ $imageUrl }}"
            alt="{{ $alt }}"
            class="w-full h-full object-cover opacity-90"
        />
    </div>
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
        <div class="text-white">
            <x-atoms.title 
                :text="$title" 
                size="sm" 
                class="text-white mb-2 lg:text-xl"
            />
            <x-atoms.description 
                size="xs" 
                color="sky-200"
                class="lg:text-base"
            >
                {{ $desc }}
            </x-atoms.description>
        </div>
    </div>
</div>