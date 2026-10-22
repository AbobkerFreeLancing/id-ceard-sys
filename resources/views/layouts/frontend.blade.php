<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ settings()?->company_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ dev()->WebsiteFaviconUrl }}">
    @filamentStyles
    <link rel="stylesheet" href="{{ asset('frontend/aos/aos.css') }}">
    @vite('resources/css/frontend.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/swiper/swiper.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom-style.css?x=' . rand(1111, 9999)) }}">
    {{-- -- SEO Meta Starts -- --}}
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta name="twitter:text:title" content="">
    <meta name="twitter:image" content="">
    <meta name="twitter:card" content="summary_large_image" />
    {{-- -- SEO Meta Ends -- --}}
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Page Container -->
    <div class="mx-auto min-w-[320px] bg-white">

        @livewire('header-component')

        <main id="page-content">{{ $slot }}</main>
        
        @include('inc.footer')
    </div>
    <!-- END Page Container -->
    <script src="{{ asset('frontend/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/js/flowbite.min.js') }}"></script>
    <script src="{{ asset('frontend/swiper/swiper.js') }}"></script>
    <script src="{{ asset('frontend/fslightbox/fslightbox.js') }}"></script>
    <script>
        AOS.init();
    </script>
    <!-- Tiny sprinkle of JS (no framework): mobile menu + year -->
    <script>
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');
        btn?.addEventListener('click', () => menu.classList.toggle('hidden'))
    </script>

    @vite(['resources/js/app.js'])
    {{-- @livewireStyles --}}
    <script src="{{ asset('frontend/js/frontend-script.js') }}"></script>
    @filamentScripts
    {{-- @livewireScriptConfig --}}
</body>

</html>
