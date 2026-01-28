{{-- resources/views/components/molecules/feature-list.blade.php --}}
@props([
    'features' => [],
])

<div class="grid lg:grid-cols-2 grid-rows-1 gap-4 pt-4">
    @foreach($features as $index => $feature)
        <x-atoms.feature-item 
            :icon="$feature['icon'] ?? ''"
            :title="$feature['title'] ?? ''"
            :description="$feature['description'] ?? ''"
        />
    @endforeach
</div>