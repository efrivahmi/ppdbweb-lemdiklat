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
  <style>
    @keyframes marquee {
      0% { transform: translateX(100vw); }
      100% { transform: translateX(-100%); }
    }
    .animate-marquee {
      display: inline-block;
      animation: marquee 20s linear infinite;
      white-space: nowrap;
    }
  </style>
</head>

<body class="h-screen flex flex-col lg:flex-row bg-gray-50">

  <div class="hidden lg:block relative w-1/2 h-full">
    <img src="{{ asset('assets/login.png') }}" alt="Sekolah"
      class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute top-8 left-4 text-black">
      <h1 class="text-4xl font-bold tracking-tight lg:text-5xl">Selamat Datang di SPMB 2026/2027</h1>
<p class="mt-4 text-lg font-medium text-gray-800 lg:text-xl">Sistem Penerimaan Murid Baru</p>
    </div>
  </div>

  <div class="flex-1 flex justify-center items-center py-10 px-6 lg:px-12 bg-gray-50 relative">
    @php
        $runningTexts = \App\Models\Settings\RunningText::where('is_active', true)->pluck('text')->toArray();
        $runningTextStr = implode(' &nbsp; &bull; &nbsp; ', $runningTexts);
    @endphp
    @if(!empty($runningTexts))
      <div class="absolute top-0 left-0 right-0 bg-lime-600 text-white overflow-hidden py-2 shadow-sm z-50 flex items-center">
          <div class="animate-marquee text-sm font-medium w-full">
              {!! $runningTextStr !!}
          </div>
      </div>
    @endif
    <div class="w-full max-w-lg mt-8 lg:mt-0">
      <x-molecules.alert />
      {{ $slot }}
    </div>
  </div>

  @livewireScripts
  @stack('scripts')
</body>

</html>