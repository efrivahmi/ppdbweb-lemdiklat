<!DOCTYPE html>
<html lang="en" class="h-full w-full overflow-hidden">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Auth' }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
  @livewireStyles
</head>

<body class="h-full w-full flex flex-col bg-gray-50 relative overflow-hidden m-0 p-0 fixed inset-0">
  @php
      $runningTexts = \App\Models\Settings\RunningText::where('is_active', true)->orderBy('order', 'asc')->get();
      $authSetting = \App\Models\Settings\AuthSetting::first();
      $bgImage = $authSetting && $authSetting->image ? asset('storage/' . $authSetting->image) : asset('assets/login.png');
      $title = $authSetting && $authSetting->title ? $authSetting->title : 'Selamat Datang di SPMB';
      $subtitle = $authSetting && $authSetting->subtitle ? $authSetting->subtitle : '2026/2027';
      $description = $authSetting && $authSetting->description ? $authSetting->description : 'Sistem Penerimaan Murid Baru';
      $subDesc = $authSetting && $authSetting->sub_description ? $authSetting->sub_description : 'Lemdiklat Taruna Nusantara Indonesia';
  @endphp

  <!-- Top Running Text (Ticker) -->
  @if($runningTexts && $runningTexts->count() > 0)
    <div class="w-full bg-white border-b border-gray-200 overflow-hidden py-2 shrink-0 flex items-center">
        <div class="bg-lime-500 text-gray-900 font-bold px-4 py-1 flex-shrink-0 z-10 uppercase text-xs tracking-widest flex items-center gap-2 shadow-sm relative ml-4 rounded-sm">
            <i class="ri-notification-3-fill"></i> INFO
        </div>
        <div class="overflow-hidden flex-1 relative h-full">
            <div class="marquee-text text-sm font-bold text-black flex items-center gap-16 absolute top-1/2 -translate-y-1/2 w-max">
                @foreach($runningTexts as $text)
                    <span class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-lime-500 rounded-full"></span>
                        {{ $text->text }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
  @endif

  <!-- Main Content Area -->
  <div class="flex-1 flex flex-col lg:flex-row relative overflow-hidden">
      <!-- Left Side: Hero Image & Branding -->
      <div class="hidden lg:block relative w-1/2 h-full z-10 shadow-2xl overflow-hidden">
        <img src="{{ $bgImage }}" alt="Sekolah"
          class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-[10s]">
        
        <div class="absolute top-4 left-12 w-full max-w-4xl pr-12 z-20">
          <svg class="w-full h-auto overflow-visible mb-4" viewBox="0 0 900 180">
             <defs>
                 <linearGradient id="heroTextGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                     <stop offset="0%" stop-color="#111827" /> <!-- gray-900 -->
                     <stop offset="100%" stop-color="#374151" /> <!-- gray-700 -->
                 </linearGradient>
                 <linearGradient id="heroLimeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                     <stop offset="0%" stop-color="#4d7c0f" />
                     <stop offset="100%" stop-color="#84cc16" />
                 </linearGradient>
             </defs>
             
             <!-- Text with White Halo (Drop Shadow) for Universal Readability -->
             <text x="0" y="60" font-family="system-ui, -apple-system, sans-serif" font-weight="900" font-size="60"
                   fill="transparent" stroke="url(#heroTextGrad)" stroke-width="2"
                   class="animate-svg-hero-text" 
                   style="--fill-color: url(#heroTextGrad);">
                 {{ $title }}
             </text>
             
             <text x="0" y="150" font-family="system-ui, -apple-system, sans-serif" font-weight="900" font-size="90"
                   fill="transparent" stroke="url(#heroLimeGrad)" stroke-width="3"
                   class="animate-svg-hero-text" 
                   style="--fill-color: url(#heroLimeGrad); animation-delay: 0.3s;">
                 {{ $subtitle }}
             </text>
          </svg>
          
          <p class="mt-4 text-2xl font-bold text-gray-900 border-l-8 border-lime-500 pl-6">
            {{ $description }} <br/>
            <span class="text-lg font-black text-gray-800">{{ $subDesc }}</span>
          </p>
        </div>
      </div>

      <!-- Right Side: Form Area -->
      <div class="flex-1 flex flex-col justify-center items-center p-4 lg:px-12 bg-white/60 backdrop-blur-3xl relative z-10 border-l border-white/50 shadow-[-20px_0_50px_rgba(0,0,0,0.15)] overflow-y-auto overflow-x-hidden">
        <div class="w-full max-w-lg my-auto pb-4 lg:pb-0">
          <x-molecules.alert />
          {{ $slot }}
        </div>
      </div>
  </div>

  @livewireScripts
  @stack('scripts')

  <style>
    @keyframes marquee-scroll {
        0%   { transform: translateX(100vw); }
        100% { transform: translateX(-100%); }
    }
    .marquee-text { animation: marquee-scroll 25s linear infinite; }
    
    .clip-path-slant {
        clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%);
    }
    
    @keyframes draw-hero-text {
        0% { stroke-dashoffset: 1200; fill: transparent; }
        60% { stroke-dashoffset: 0; fill: transparent; }
        100% { stroke-dashoffset: 0; fill: var(--fill-color); stroke-width: 0.5px; }
    }
    .animate-svg-hero-text {
        stroke-dasharray: 1200;
        stroke-dashoffset: 1200;
        animation: draw-hero-text 3.5s ease-in-out forwards;
    }
  </style>
</body>

</html>