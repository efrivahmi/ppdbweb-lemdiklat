<!DOCTYPE html>
<html lang="en" class="h-full" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @livewireStyles
</head>

<body class="bg-gray-50 font-sans antialiased h-full">
    <x-molecules.alert />
    
    <div class="flex h-screen overflow-hidden bg-gray-50">
        {{-- Sidebar (Fixed Left) --}}
        <div class="shrink-0">
            @livewire('components.admin.sidebar')
        </div>

        {{-- Main Content Area (Fluid Right) --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            {{-- Topbar --}}
            @livewire('components.admin.navbar')
            
            {{-- Scrollable Content --}}
            <main class="flex-1 overflow-y-auto bg-gray-50/50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>