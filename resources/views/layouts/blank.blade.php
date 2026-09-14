<!DOCTYPE html>
<html lang="en" class="h-full w-full overflow-hidden">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'SPMB' }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
  @livewireStyles
</head>

<body class="h-full w-full bg-gray-50 m-0 p-0 fixed inset-0 overflow-hidden font-sans">
  {{ $slot }}

  @livewireScripts
  @stack('scripts')
</body>
</html>
