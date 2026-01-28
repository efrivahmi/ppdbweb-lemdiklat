@props([
    'label' => '',
    'inputType' => 'text',
    'name' => '',
    'id' => '',
    'placeholder' => '',
    'error' => '',
    'required' => false,
])

@php
    $isPassword = $inputType === 'password';
    $uniqueId = $id ?: $name ?: 'input_' . uniqid();
@endphp

<div class="">
    <x-atoms.label :for="$uniqueId">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </x-atoms.label>
    
    @if($isPassword)
        {{-- Password Field with Toggle --}}
        <div class="relative" x-data="{ showPassword: false }">
            <input
                x-bind:type="showPassword ? 'text' : 'password'"
                name="{{ $name }}"
                id="{{ $uniqueId }}"
                placeholder="{{ $placeholder }}"
                class="pr-12 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out {{ $attributes->get('class') }}"
                {{ $attributes->except(['label', 'inputType', 'name', 'id', 'placeholder', 'error', 'required', 'class']) }}
            />
            
            <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none transition-colors duration-200"
            >
                <i x-show="!showPassword" class="ri-eye-line text-lg"></i>
                <i x-show="showPassword" class="ri-eye-off-line text-lg" x-cloak></i>
            </button>
        </div>
    @else
        {{-- Regular Input Field --}}
        <div class="relative">
            <x-atoms.input
                :type="$inputType"
                :name="$name"
                :id="$uniqueId"
                :placeholder="$placeholder"
                {{ $attributes->except(['label', 'inputType', 'name', 'id', 'placeholder', 'error', 'required']) }}
            />
        </div>
    @endif
    
    @if($error)
        <p class="text-sm text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>

<style>
    [x-cloak] { display: none !important; }
</style>