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
    
    <div class="relative group">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $id ?: $name }}"
            accept="{{ $accept }}"
            @if($disabled) disabled @endif
            class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer {{ $disabled ? 'cursor-not-allowed' : '' }}"
            {{ $attributes->except(['label', 'name', 'id', 'currentFile', 'error', 'required', 'accept', 'maxSize', 'disabled', 'className']) }}
        />
        
        <div class="flex items-center w-full border rounded-md overflow-hidden {{ $error ? 'border-red-500' : 'border-gray-300' }} {{ $disabled ? 'bg-gray-100' : 'bg-white' }} transition-colors duration-200">
            <div class="px-4 py-2 {{ $disabled ? 'bg-gray-200 text-gray-500' : 'bg-lime-50 text-lime-700 group-hover:bg-lime-100' }} border-r border-gray-200 font-semibold text-sm transition-colors">
                Pilih File
            </div>
            <div class="px-4 py-2 text-sm text-gray-500 flex-1 truncate">
                @if($currentFile)
                    @if(is_array($currentFile))
                        {{ $currentFile['name'] ?? 'Unknown file' }}
                    @elseif(is_object($currentFile) && method_exists($currentFile, 'getClientOriginalName'))
                        {{ $currentFile->getClientOriginalName() }}
                    @else
                        {{ $currentFile }}
                    @endif
                @else
                    Tidak ada file yang dipilih
                @endif
            </div>
        </div>
    </div>
    
    <div class="mt-1 text-xs text-gray-500">
        Format: {{ strtoupper(str_replace(['.', ','], ['', ', '], $accept)) }} • Maksimal: {{ $maxSize }}
    </div>
    
    @if($error)
        <p class="text-sm text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>