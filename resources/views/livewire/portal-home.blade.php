<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    <!-- Hero Section with Quick Verify Widget -->
    <section class="relative text-center pt-8 pb-12">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            نظام الهوية الذكية المتوافق مع معايير CR80 والتشفير الأمني
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
            المنصة الذكية لإدارة، طباعة
            <br>
            <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">
                وتحقق البطاقات التعريفية
            </span>
        </h1>

        <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-400 mb-10 leading-relaxed">
            حل رقمي متكامل للمؤسسات والجامعات لإصدار هويات آمنة مشفرة بتواقيع رقمية، مع محرك فحص سريع لحظي لمسؤولي الأمن والجهات الرقابية.
        </p>

        <!-- Quick Verification Search Box -->
        <div class="max-w-2xl mx-auto">
            <form wire:submit.prevent="quickVerify" class="glass-panel p-2.5 rounded-2xl shadow-2xl shadow-emerald-950/40 border border-slate-800 flex flex-col sm:flex-row gap-2">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model="quickUid" 
                        placeholder="أدخل رمز البطاقة (UID) للتحقق الفوري..."
                        class="w-full pl-4 pr-11 py-3.5 bg-slate-900/90 text-white rounded-xl border border-slate-700/60 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm placeholder-slate-500 transition-all font-mono-num"
                    >
                </div>
                <button 
                    type="submit" 
                    class="px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/25 active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>فحص فوري</span>
                </button>
            </form>

            <div class="mt-3 flex items-center justify-center gap-4 text-xs text-slate-400">
                <span>أو تصفح:</span>
                <a href="{{ route('cards.verify') }}" class="text-emerald-400 hover:underline">ماسح QR الذكي</a>
                <span>•</span>
                <a href="{{ route('cardholders.directory') }}" class="text-emerald-400 hover:underline">دليل حاملي البطاقات</a>
                <span>•</span>
                <a href="{{ route('reissues.track') }}" class="text-emerald-400 hover:underline">متابعة بدل الفاقد</a>
            </div>
        </div>
    </section>

    <!-- Real-time Stats Grid -->
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400">المؤسسات المسجلة</span>
                <div class="w-9 h-9 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono-num">{{ $stats['organizations'] }}</div>
            <p class="text-xs text-slate-400 mt-1">جهات وهيئات مستقلة</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400">حاملو البطاقات</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono-num">{{ $stats['cardholders'] }}</div>
            <p class="text-xs text-slate-400 mt-1">موظفون وطلاب معتمدون</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400">البطاقات السارية</span>
                <div class="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono-num">{{ $stats['active_cards'] }}</div>
            <p class="text-xs text-slate-400 mt-1">بطاقة ذكية نشطة حالياً</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400">عمليات الفحص الناجحة</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono-num">{{ $stats['valid_scans'] }}</div>
            <p class="text-xs text-slate-400 mt-1">سجل تحقق أمني مسجل</p>
        </div>
    </section>

    <!-- Core Pillars / Features Section -->
    <section class="space-y-8">
        <div class="text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">مميزات منظومة الهوية الذكية</h2>
            <p class="text-slate-400 text-sm mt-2">معمارية متطورة تلبي أعلى معايير الأمان والجودة العالمية</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 hover:border-emerald-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">تشفير QR والتوقيع الرقمي</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    يحتوي كل رمز QR على حمولة موقعة رقمياً بخوارزمية HMAC مع طابع زمني، مما يمنع التزييف والنسخ غير المصرح به.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 hover:border-teal-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">دفعات الطباعة لمعيار CR80</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    توليد ملفات PDF عالية الدقة (300/600 DPI) للطباعة المجمعة على أوراق A4 بعدد 8 أو 10 بطاقات بنظام ترتيب إحداثيات دقيق.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 hover:border-cyan-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">سجل تدقيق وتتبع الفحوصات</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    تسجيل كل محاولة مسح مع توثيق الوقت، معرّف الجهاز، عنوان IP، والإحداثيات الجغرافية لكشف محاولات الاختراق والاحتيال.
                </p>
            </div>
        </div>
    </section>

    <!-- Quick Links Grid -->
    <section class="glass-panel p-8 rounded-3xl border border-slate-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-xl font-bold text-white mb-1">بوابات النظام السريعة</h3>
                <p class="text-sm text-slate-400">اختر الوجهة المطلوبة للتفاعل المباشر مع مكونات النظام</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('cards.verify') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700 text-sm font-semibold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>ماسح التحقق الذكي</span>
                </a>

                <a href="{{ route('cardholders.directory') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-sm font-semibold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>دليل البطاقات والحاملين</span>
                </a>

                <a href="{{ route('reissues.track') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-sm font-semibold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>متابعة بدل الفاقد / التالف</span>
                </a>
            </div>
        </div>
    </section>

</div>
