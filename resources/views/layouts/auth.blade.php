<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Auth' }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
  @livewireStyles
</head>

<body class="h-screen flex flex-col lg:flex-row bg-gray-50">

  <div class="hidden lg:block relative w-1/2 h-full">
    <img src="{{ asset('assets/login.png') }}" alt="Sekolah"
      class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute bottom-8 left-8 text-white">
      <h1 class="text-3xl font-bold">Selamat Datang di SPMB 2026/2027</h1>
      <p class="text-gray-200 mt-2">Sistem Penerimaan Murid Baru</p>
      <p class="text-gray-200 mt-2">Copyright © 2026 Lemdiklat Taruna Nusantara Indonesia</p>
    </div>
  </div>

  <div class="flex-1 flex justify-center items-center py-10 px-6 lg:px-12 bg-gray-50">
    <div class="w-full max-w-lg">
      <x-molecules.alert />
      {{ $slot }}
    </div>
  </div>

  @livewireScripts
  @stack('scripts')
</body>

</html>