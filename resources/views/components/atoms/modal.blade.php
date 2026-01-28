@props([
    'name' => 'modal',
    'maxWidth' => '2xl',
    'closeable' => true,
    'static' => false,
])

@php
$maxWidthClasses = [
    'xs' => 'sm:max-w-xs',
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    'full' => 'sm:max-w-full',
];

$maxWidthClass = $maxWidthClasses[$maxWidth] ?? $maxWidthClasses['2xl'];
@endphp

<div
    x-data="{ 
        show: false,
        open() {
            this.show = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            if ({{ $closeable ? 'true' : 'false' }}) {
                this.show = false;
                document.body.style.overflow = '';
            }
        }
    }"
    x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') open()"
    x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') close()"
    x-show="show"
    x-cloak
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @if($closeable)
        @keydown.escape.window="close()"
    @endif
    style="display: none;"
>
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div
            class="w-full {{ $maxWidthClass }} transform overflow-hidden rounded-xl bg-white shadow-2xl"
            @click.outside="!{{ $static ? 'true' : 'false' }} && close()"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            {{ $slot }}
        </div>
    </div>
</div>
