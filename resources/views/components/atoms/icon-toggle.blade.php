@props([
    'isOpen' => false,
])

<button
    x-data="{ isOpen: @js($isOpen) }"
    x-on:click="isOpen = !isOpen; $dispatch('toggle', { isOpen })"
    class="md:hidden text-white text-3xl focus:outline-none"
    aria-label="Toggle Menu"
    {{ $attributes }}
>
    <i x-show="!isOpen" class="ri-menu-line"></i>
    <i x-show="isOpen" class="ri-close-line"></i>
</button>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush