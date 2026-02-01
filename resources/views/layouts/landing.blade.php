{{-- resources/views/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $title ?? config('app.seo.default_title', 'Lemdiklat Taruna Nusantara Indonesia') }}</title>

    {{-- SEO Meta Tags --}}
    @isset($seo)
        {!! App\Helpers\SeoHelper::metaTags($seo) !!}
    @else
        {!! App\Helpers\SeoHelper::metaTags(App\Helpers\SeoHelper::defaults()) !!}
    @endisset

    {{-- Structured Data --}}
    @isset($article)
        {!! App\Helpers\SeoHelper::articleSchema($article) !!}
    @else
        {!! App\Helpers\SeoHelper::organizationSchema() !!}
    @endisset

    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col bg-zinc-50 text-zinc-800 font-sans">
    <x-molecules.alert />
    
    @livewire('components.landing.navbar')
    
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>
    
    @livewire('components.landing.footer-section')
    
    @livewireScripts
    
    {{-- Scroll Reveal Animation Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for scroll reveal animations
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Optional: unobserve after animation (for one-time animation)
                        // observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all elements with reveal-on-scroll class
            document.querySelectorAll('.reveal-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // Also observe sections for smooth fade-in
            document.querySelectorAll('section').forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                section.style.transitionDelay = `${index * 100}ms`;
                
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });
    </script>
</body>
</html>