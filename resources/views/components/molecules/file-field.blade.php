@props([
    'label' => '',
    'name' => '',
    'id' => '',
    'currentFile' => null,
    'error' => '',
    'required' => false,
    'accept' => '.pdf,.jpg,.jpeg,.png',
    'maxSize' => '2MB',
    'disabled' => false,
    'className' => '',
])

@php
$baseInputClass = "w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition duration-200 ease-in-out file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-50 file:text-lime-700 hover:file:bg-lime-100";

$inputClasses = trim(implode(' ', [
    $baseInputClass,
    $disabled ? 'bg-gray-100 cursor-not-allowed file:bg-gray-100 file:text-gray-500' : '',
    $error ? 'border-red-500 focus:ring-red-500' : '',
    $className
]));
@endphp

<div class="mb-4">
    <x-atoms.label :for="$id ?: $name">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </x-atoms.label>
    
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $id ?: $name }}"
        accept="{{ $accept }}"
        @if($disabled) disabled @endif
        class="{{ $inputClasses }}"
        {{ $attributes->except(['label', 'name', 'id', 'currentFile', 'error', 'required', 'accept', 'maxSize', 'disabled', 'className']) }}
    />
    
    <div class="mt-1 text-xs text-gray-500">
        Format: {{ strtoupper(str_replace(['.', ','], ['', ', '], $accept)) }} • Maksimal: {{ $maxSize }}
    </div>
    
    @if($currentFile)
        <div class="mt-1 text-sm text-lime-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            File terpilih: 
            @if(is_array($currentFile))
                {{ $currentFile['name'] ?? 'Unknown file' }}
            @elseif(is_object($currentFile) && method_exists($currentFile, 'getClientOriginalName'))
                {{ $currentFile->getClientOriginalName() }}
            @else
                {{ $currentFile }}
            @endif
        </div>
    @endif
    
    @if($error)
        <p class="text-sm text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>