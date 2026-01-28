@props([
    'label' => '',
    'name' => '',
    'id' => '',
    'value' => '',
    'options' => [],
    'error' => '',
    'required' => false,
    'placeholder' => 'Pilih opsi...',
    'disabled' => false,
    'className' => '',
])

@php
$baseSelectClass = "w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out appearance-none";

$selectClasses = trim(implode(' ', [
    $baseSelectClass,
    $disabled ? 'bg-gray-100 cursor-not-allowed' : '',
    $error ? 'border-red-500 focus:ring-red-500' : '',
    $className
]));
@endphp

<div class="">
    <x-atoms.label :for="$id ?: $name">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </x-atoms.label>
    
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $id ?: $name }}"
            @if($disabled) disabled @endif
            class="{{ $selectClasses }}"
            {{ $attributes->except(['label', 'name', 'id', 'value', 'options', 'error', 'required', 'placeholder', 'disabled', 'className']) }}
        >
            @if($placeholder)
                <option value="" disabled @if(!$value) selected @endif>
                    {{ $placeholder }}
                </option>
            @endif
            @foreach($options as $option)
                <option 
                    value="{{ $option['value'] ?? '' }}" 
                    @if($value == ($option['value'] ?? '')) selected @endif
                >
                    {{ $option['label'] ?? $option['text'] ?? '' }}
                </option>
            @endforeach
        </select>
        
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400"/>
        </div>
    </div>
    
    @if($error)
        <p class="text-sm text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>