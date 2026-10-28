<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold mb-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>سجل الهويات المعتمدة</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">دليل حاملي البطاقات الذكية</h1>
            <p class="text-slate-400 text-sm mt-1">تصفح والبحث اللحظي في قاعدة بيانات الأشخاص المسجلين والبطاقات المصدرة لهم.</p>
        </div>

        <!-- View Mode Switch -->
        <div class="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
            <button 
                type="button" 
                wire:click="$set('viewMode', 'grid')" 
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $viewMode === 'grid' ? 'bg-emerald-500 text-slate-950 shadow-sm' : 'text-slate-400 hover:text-white' }}"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                <span>بطاقات (CR80)</span>
            </button>
            <button 
                type="button" 
                wire:click="$set('viewMode', 'table')" 
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $viewMode === 'table' ? 'bg-emerald-500 text-slate-950 shadow-sm' : 'text-slate-400 hover:text-white' }}"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                <span>جدول تفصيلي</span>
            </button>
        </div>
    </div>

    <!-- Live Filter Bar -->
    <div class="glass-panel p-5 rounded-2xl border border-slate-800 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search Input -->
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.350ms="search" 
                    placeholder="ابحث بالاسم، الرقم القومي، الوظيفي..."
                    class="w-full pl-3 pr-9 py-2.5 bg-slate-900/90 text-white rounded-xl border border-slate-700 focus:border-emerald-500 text-xs placeholder-slate-500 transition-all"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>

            <!-- Organization Filter -->
            <div>
                <select 
                    wire:model.live="organizationId" 
                    class="w-full px-3 py-2.5 bg-slate-900/90 text-white rounded-xl border border-slate-700 focus:border-emerald-500 text-xs transition-all"
                >
                    <option value="">جميع المؤسسات</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">{{ $org->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Filter -->
            <div>
                <select 
                    wire:model.live="departmentId" 
                    class="w-full px-3 py-2.5 bg-slate-900/90 text-white rounded-xl border border-slate-700 focus:border-emerald-500 text-xs transition-all"
                >
                    <option value="">جميع الأقسام</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Card Status Filter -->
            <div>
                <select 
                    wire:model.live="status" 
                    class="w-full px-3 py-2.5 bg-slate-900/90 text-white rounded-xl border border-slate-700 focus:border-emerald-500 text-xs transition-all"
                >
                    <option value="">حالة البطاقة (الكل)</option>
                    <option value="has_active">يحمل بطاقة نشطة</option>
                    <option value="no_card">بدون بطاقات مصدرة</option>
                </select>
            </div>
        </div>

        @if($search || $organizationId || $departmentId || $status)
            <div class="flex items-center justify-between text-xs text-slate-400 pt-2 border-t border-slate-800">
                <span>تم العثور على <strong>{{ $cardholders->total() }}</strong> حامل بطاقة</span>
                <button type="button" wire:click="resetFilters" class="text-emerald-400 hover:underline">
                    إلغاء التصفية وإعادة التعيين
                </button>
            </div>
        @endif
    </div>

    <!-- Data Display: Grid vs Table -->
    @if($cardholders->isEmpty())
        <div class="glass-panel p-12 rounded-3xl text-center border border-slate-800 space-y-3">
            <svg class="w-16 h-16 text-slate-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-bold text-white">لا توجد نتائج مطابقة</h3>
            <p class="text-slate-400 text-xs max-w-sm mx-auto">
                لم نتمكن من العثور على حاملي بطاقات يطابقون معايير البحث المحددة. جرب تغيير كلمات البحث أو مسح الفلاتر.
            </p>
        </div>
    @elseif($viewMode === 'grid')
        <!-- Interactive CR80 Cards Grid with Flip Effect -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($cardholders as $holder)
                @php
                    $activeCard = $holder->activeCard;
                    $isFlipped = ($flippedCardId === $holder->id);
                @endphp
                <div class="card-perspective h-[270px]">
                    <div class="card-inner relative w-full h-full rounded-2xl shadow-xl transition-all duration-500 {{ $isFlipped ? 'card-flipped' : '' }}">
                        
                        <!-- CARD FRONT -->
                        <div class="card-face absolute inset-0 glass-panel rounded-2xl p-5 border border-slate-700/80 bg-gradient-to-br from-slate-900/90 via-slate-800/80 to-slate-900/90 flex flex-col justify-between overflow-hidden">
                            <!-- Top Bar: Org & Flip Trigger -->
                            <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-xs">
                                        {{ mb_substr($holder->organization->name_ar ?? 'H', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-white">{{ $holder->organization->name_ar ?? 'المؤسسة الوطنية' }}</h4>
                                        <span class="text-[10px] text-slate-400 block">{{ $holder->department->name_ar ?? 'القسم العام' }}</span>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    wire:click="toggleFlip({{ $holder->id }})" 
                                    title="اقلب البطاقة للوجه الخلفي"
                                    class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-emerald-400 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Middle: Photo & Info -->
                            <div class="flex items-center gap-4 my-2">
                                <div class="w-18 h-22 rounded-xl bg-slate-800 border border-emerald-500/30 overflow-hidden shrink-0 flex items-center justify-center shadow-inner">
                                    @if($holder->photo_path)
                                        <img src="{{ asset('storage/' . $holder->photo_path) }}" alt="{{ $holder->full_name_ar }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-grow space-y-1">
                                    <h5 class="text-sm font-bold text-white">{{ $holder->full_name_ar }}</h5>
                                    <p class="text-[11px] text-slate-400">{{ $holder->full_name_en }}</p>
                                    <div class="flex items-center gap-2 pt-1">
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-slate-800 font-mono-num text-slate-300">
                                            ID: {{ $holder->national_id }}
                                        </span>
                                        @if($holder->blood_type)
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-rose-500/10 text-rose-400 font-bold font-mono-num">
                                                {{ $holder->blood_type }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Bar: Status & Direct Verification Link -->
                            <div class="flex items-center justify-between pt-2 border-t border-slate-700/60 text-xs">
                                <div>
                                    @if($activeCard)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            بطاقة نشطة: {{ $activeCard->card_uid }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 text-[10px]">
                                            لا توجد بطاقة سارية
                                        </span>
                                    @endif
                                </div>

                                @if($activeCard)
                                    <a 
                                        href="{{ route('cards.verify', ['uid' => $activeCard->card_uid]) }}" 
                                        class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1"
                                    >
                                        <span>فحص وتدقيق</span>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- CARD BACK (FLIPPED) -->
                        <div class="card-face card-back absolute inset-0 glass-panel rounded-2xl p-5 border border-slate-700/80 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 flex flex-col justify-between overflow-hidden">
                            <!-- Magnetic Stripe -->
                            <div class="-mx-5 -mt-2 h-9 bg-slate-950 border-y border-slate-800"></div>

                            <div class="text-center space-y-2 px-2">
                                <p class="text-[10px] text-slate-400 leading-tight">
                                    هذه البطاقة وثيقة رسمية تخص حاملها فقط ويجب إبرازها عند الطلب. في حال العثور عليها يرجى تسليمها للجهة المصدرة.
                                </p>
                                <div class="font-mono-num text-xs text-slate-300 tracking-wider">
                                    {{ $activeCard ? 'CARD REF: ' . $activeCard->card_uid : 'NO ACTIVE ISSUE' }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-slate-800 text-[10px] text-slate-400">
                                <button type="button" wire:click="toggleFlip({{ $holder->id }})" class="text-emerald-400 hover:underline">
                                    ← العودة للواجهة الأمامية
                                </button>
                                <span>صلاحية معتمدة إلكترونياً</span>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Table Mode -->
        <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-900/80 text-slate-400 font-semibold border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">حامل البطاقة</th>
                            <th class="py-3 px-4">المؤسسة / القسم</th>
                            <th class="py-3 px-4">الرقم القومي</th>
                            <th class="py-3 px-4">حالة البطاقة</th>
                            <th class="py-3 px-4 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($cardholders as $holder)
                            @php $activeCard = $holder->activeCard; @endphp
                            <tr class="hover:bg-slate-900/40 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-xs text-emerald-400">
                                            {{ mb_substr($holder->full_name_ar, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">{{ $holder->full_name_ar }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $holder->full_name_en }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300">
                                    <div>{{ $holder->organization->name_ar ?? '---' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $holder->department->name_ar ?? 'العام' }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-mono-num text-slate-300">
                                    {{ $holder->national_id }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($activeCard)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-semibold">
                                            سارية ({{ $activeCard->card_uid }})
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">بدون بطاقة</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($activeCard)
                                        <a href="{{ route('cards.verify', ['uid' => $activeCard->card_uid]) }}" class="px-3 py-1 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-semibold transition-colors">
                                            فحص
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    <div class="pt-4">
        {{ $cardholders->links() }}
    </div>

</div>
