@props([
    "currentPath" => ""
])

<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="#" class="text-gray-500 hover:text-gray-700">
                    <x-heroicon-o-home class="w-5 h-5"/>
                </a>
            </li>
            <li>
                <x-heroicon-o-chevron-right class="w-4 h-4"/>
            </li>
            <li>
                <span class="text-gray-700 font-medium capitalize">{{ $currentPath }}</span>
            </li>
        </ol>
    </nav>
</div>