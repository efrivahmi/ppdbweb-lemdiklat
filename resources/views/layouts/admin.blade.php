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

<body class="bg-stone-100 font-sans antialiased h-full" x-data="{ sidebarOpen: false }">
    <x-molecules.alert />
    
    <div class="flex flex-col h-screen overflow-hidden bg-stone-100">
        {{-- Full-width Navbar (Fixed at top with z-40 to stay above sidebar) --}}
        <div class="sticky top-0 z-40 shrink-0">
            @livewire('components.admin.navbar')
        </div>
        
        {{-- Content Area with Sidebar --}}
        <div class="flex flex-1 overflow-hidden">
            {{-- Sidebar --}}
            @livewire('components.admin.sidebar')

            {{-- Main Content Area (Fluid Right) --}}
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-stone-50 via-stone-100 to-emerald-50/30 p-6 lg:ml-0">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>