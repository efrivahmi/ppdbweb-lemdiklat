<!DOCTYPE html>
<html lang="en" class="h-full" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Guru Panel' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @livewireStyles
</head>

<body class="bg-gray-50 overflow-hidden">
    <x-molecules.alert />
    <div class="flex flex-col h-screen overflow-hidden">
        @livewire('components.guru.navbar')
        <div class="flex-1 flex overflow-y-hidden">
            @livewire('components.guru.sidebar')
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>