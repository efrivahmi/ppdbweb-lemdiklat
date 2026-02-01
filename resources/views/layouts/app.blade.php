<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" class="h-full" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @livewireStyles
    
    <style>
        /* Glass scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, rgba(132, 204, 22, 0.4), rgba(132, 204, 22, 0.2));
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, rgba(132, 204, 22, 0.6), rgba(132, 204, 22, 0.4));
        }
        
        /* Smooth page transitions */
        .page-enter {
            animation: fadeSlideIn 0.4s ease-out;
        }
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Glass table styling */
        .glass-table tbody tr:nth-child(even) {
            background: rgba(132, 204, 22, 0.03);
        }
        .glass-table tbody tr {
            transition: all 0.2s ease;
        }
        .glass-table tbody tr:hover {
            background: rgba(132, 204, 22, 0.08);
            transform: scale(1.005);
        }
        
        /* Spotlight effect for main content */
        .spotlight-subtle {
            background: radial-gradient(ellipse 60% 40% at 80% 20%, rgba(132, 204, 22, 0.05), transparent);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-white to-lime-50/20 overflow-hidden">
    <x-molecules.alert />
    
    <div class="flex flex-col h-screen overflow-hidden">
        @livewire('components.admin.navbar')
        
        <div class="flex-1 flex overflow-y-hidden">
            @livewire('components.admin.sidebar')
            
            <!-- Main Content Area with subtle spotlight -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto 
                         bg-gradient-to-br from-transparent to-lime-50/10
                         spotlight-subtle p-6 page-enter">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
