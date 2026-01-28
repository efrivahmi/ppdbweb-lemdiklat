@props([
    'label' => '',
    'name' => '',
    'id' => '',
    'placeholder' => '',
    'rows' => 3,
    'error' => '',
    'required' => false,
])

@php
$textareaId = $id ?: $name;
$errorClass = $error ? 'border-red-500 focus:ring-red-500' : '';
@endphp

<div class="mb-4">
    <x-atoms.label :for="$textareaId">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </x-atoms.label>
    
    <textarea
        name="{{ $name }}"
        id="{{ $textareaId }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        rows="{{ $rows }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out {{ $errorClass }}"
        {{ $attributes->except(['label', 'name', 'id', 'placeholder', 'rows', 'error', 'required']) }}
    ></textarea>
    
    @if($error)
        <p class="text-sm text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>