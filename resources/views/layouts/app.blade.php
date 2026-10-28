<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'منظومة هوية ID | فحص وإدارة البطاقات الذكية' }}</title>

    <!-- Google Fonts: Cairo & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }
        .font-mono-num {
            font-family: 'Outfit', monospace, sans-serif;
            letter-spacing: 0.05em;
        }
        .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .card-perspective {
            perspective: 1000px;
        }
        .card-inner {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }
        .card-flipped {
            transform: rotateY(180deg);
        }
        .card-face {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .card-back {
            transform: rotateY(180deg);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col selection:bg-emerald-500 selection:text-slate-950 antialiased relative overflow-x-hidden">

    <!-- Ambient Glow Background Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 right-1/4 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -left-20 w-96 h-96 bg-cyan-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-1/3 w-80 h-80 bg-indigo-600/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-50 glass-panel border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-6 h-6 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-bold bg-gradient-to-l from-emerald-400 via-teal-200 to-white bg-clip-text text-transparent">هوية ID</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">ذكي & آمن</span>
                        </div>
                        <p class="text-xs text-slate-400">منظومة فحص وإدارة البطاقات الذكية</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-slate-800 text-emerald-400 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        الرئيسية
                    </a>
                    <a href="{{ route('cards.verify') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cards.verify') ? 'bg-slate-800 text-emerald-400 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        فحص وتحقق البطاقة
                    </a>
                    <a href="{{ route('cardholders.directory') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cardholders.directory') ? 'bg-slate-800 text-emerald-400 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        دليل الحاملين
                    </a>
                    <a href="{{ route('reissues.track') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('reissues.track') ? 'bg-slate-800 text-emerald-400 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        تتبع إعادة الإصدار
                    </a>
                </nav>

                <!-- Actions / Admin Button -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/admin') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-slate-950 shadow-md shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span>لوحة الإدارة</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow z-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="glass-panel border-t border-slate-800/80 mt-16 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-right">
                <div class="flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs text-slate-400">محرك الفحص الآمن والتحقق اللحظي نشط 24/7</span>
                </div>

                <div class="text-xs text-slate-400">
                    جميع الحقوق محفوظة &copy; {{ date('Y') }} منظومة <strong class="text-slate-200">هوية ID</strong> | معيار CR80 الذكي
                </div>

                <div class="flex items-center gap-4 text-xs text-slate-400">
                    <a href="{{ route('cards.verify') }}" class="hover:text-emerald-400 transition-colors">بوابة الفحص</a>
                    <span>•</span>
                    <a href="{{ route('cardholders.directory') }}" class="hover:text-emerald-400 transition-colors">قائمة البطاقات</a>
                    <span>•</span>
                    <a href="{{ url('/admin') }}" class="hover:text-emerald-400 transition-colors">الإدارة</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
