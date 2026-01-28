@props([
    'icon' => '',
    'title' => '',
    'description' => '',
])

<div class="flex items-start gap-3">
    <div class="w-10 h-10 rounded-lg bg-lime-50 flex items-center justify-center flex-shrink-0">
        @if($icon)
            <i class="{{ $icon }} w-5 h-5 text-lime-600"></i>
        @else
            {{ $iconSlot ?? '' }}
        @endif
    </div>
    <div>
        <x-atoms.title 
            :text="$title" 
            size="sm" 
            class="lg:text-lg"
        />
        <x-atoms.description 
            size="xs" 
            class="lg:text-sm" 
            color="gray-600"
        >
            {{ $description }}
        </x-atoms.description>
    </div>
</div>