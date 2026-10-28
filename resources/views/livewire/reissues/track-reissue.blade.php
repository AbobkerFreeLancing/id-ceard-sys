<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-10">

    <!-- Header Section -->
    <div class="text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span>خدمة متابعة بدل الفاقد والتالف</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">تتبع طلبات إعادة إصدار الهوية</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            استعلم عن حالة طلب استبدال البطاقة (المفقودة، التالفة، أو تغيير البيانات) ومعرفة مراحل الموافقة وتاريخ استلام البطاقة الجديدة.
        </p>
    </div>

    <!-- Query Input Box -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-2xl relative">
        <form wire:submit.prevent="search" class="space-y-4">
            <div>
                <label for="queryInput" class="block text-xs font-semibold text-slate-300 mb-2">
                    الرقم القومي أو رمز البطاقة السابقة (Old Card UID)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="queryInput"
                        wire:model="queryInput" 
                        placeholder="أدخل الرقم القومي لحامل البطاقة أو كود البطاقة القديمة..."
                        class="w-full pl-4 pr-11 py-3.5 bg-slate-900/90 text-white rounded-xl border {{ $errors->has('queryInput') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm font-mono-num placeholder-slate-500 transition-all"
                    >
                </div>
                @error('queryInput')
                    <p class="text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-400 hover:to-cyan-400 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="search" class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>استعلام عن مسار الطلب</span>
                    </span>
                    <span wire:loading wire:target="search" class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>جاري البحث في الأرشيف...</span>
                    </span>
                </button>

                @if($searched)
                    <button 
                        type="button" 
                        wire:click="resetSearch" 
                        class="w-full sm:w-auto px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors"
                    >
                        استعلام جديد
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Search Results -->
    @if($searched)
        <div class="space-y-6 animate-fadeIn">
            @if($reissue)
                <!-- Request Found Card -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-8">
                    <!-- Request Summary -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-800 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-lg">
                                {{ mb_substr($reissue->oldCard->cardholder->full_name_ar ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">{{ $reissue->oldCard->cardholder->full_name_ar ?? 'غير معروف' }}</h3>
                                <p class="text-xs text-slate-400">
                                    {{ $reissue->oldCard->cardholder->organization->name_ar ?? '---' }} | الرقم القومي: <span class="font-mono-num">{{ $reissue->oldCard->cardholder->national_id }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold 
                                @if($reissue->status->value === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/30
                                @elseif($reissue->status->value === 'approved') bg-cyan-500/10 text-cyan-400 border border-cyan-500/30
                                @elseif($reissue->status->value === 'pending') bg-amber-500/10 text-amber-400 border border-amber-500/30
                                @else bg-rose-500/10 text-rose-400 border border-rose-500/30 @endif
                            ">
                                <span class="w-2 h-2 rounded-full 
                                    @if($reissue->status->value === 'completed') bg-emerald-400
                                    @elseif($reissue->status->value === 'approved') bg-cyan-400
                                    @elseif($reissue->status->value === 'pending') bg-amber-400
                                    @else bg-rose-400 @endif
                                "></span>
                                {{ $reissue->status->getLabel() }}
                            </span>
                        </div>
                    </div>

                    <!-- Visual Timeline Stepper -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">مراحل مسار المعالجة:</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                            <!-- Step 1: Request Submitted -->
                            <div class="p-4 rounded-xl border bg-slate-900/60 {{ in_array($reissue->status->value, ['pending', 'approved', 'completed']) ? 'border-indigo-500/40 text-indigo-300' : 'border-slate-800 text-slate-500' }}">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold">1</span>
                                    <span class="font-bold text-xs">تقديم الطلب</span>
                                </div>
                                <p class="text-[10px] text-slate-400">السبب: {{ $reissue->reason->getLabel() }}</p>
                                <span class="text-[9px] text-slate-500 font-mono-num block mt-1">{{ $reissue->created_at->format('Y-m-d') }}</span>
                            </div>

                            <!-- Step 2: Approval -->
                            <div class="p-4 rounded-xl border bg-slate-900/60 {{ in_array($reissue->status->value, ['approved', 'completed']) ? 'border-cyan-500/40 text-cyan-300' : 'border-slate-800 text-slate-500' }}">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-6 h-6 rounded-full {{ in_array($reissue->status->value, ['approved', 'completed']) ? 'bg-cyan-500/20 text-cyan-400' : 'bg-slate-800 text-slate-500' }} flex items-center justify-center text-xs font-bold">2</span>
                                    <span class="font-bold text-xs">الاعتماد الإداري</span>
                                </div>
                                <p class="text-[10px] text-slate-400">
                                    {{ $reissue->approved_by ? 'تمت الموافقة' : 'قيد التدقيق' }}
                                </p>
                            </div>

                            <!-- Step 3: Printing Generation -->
                            <div class="p-4 rounded-xl border bg-slate-900/60 {{ $reissue->status->value === 'completed' ? 'border-teal-500/40 text-teal-300' : 'border-slate-800 text-slate-500' }}">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-6 h-6 rounded-full {{ $reissue->status->value === 'completed' ? 'bg-teal-500/20 text-teal-400' : 'bg-slate-800 text-slate-500' }} flex items-center justify-center text-xs font-bold">3</span>
                                    <span class="font-bold text-xs">تجهيز البطاقة</span>
                                </div>
                                <p class="text-[10px] text-slate-400">ضمن دفعة الطباعة</p>
                            </div>

                            <!-- Step 4: Handover -->
                            <div class="p-4 rounded-xl border bg-slate-900/60 {{ $reissue->status->value === 'completed' ? 'border-emerald-500/40 text-emerald-300' : 'border-slate-800 text-slate-500' }}">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-6 h-6 rounded-full {{ $reissue->status->value === 'completed' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-800 text-slate-500' }} flex items-center justify-center text-xs font-bold">4</span>
                                    <span class="font-bold text-xs">جاهز للتسليم</span>
                                </div>
                                <p class="text-[10px] text-slate-400">
                                    {{ $reissue->newCard ? 'كود: ' . $reissue->newCard->card_uid : 'قيد الإجراء' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Details & Notes Area -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-4 border-t border-slate-800">
                        <div>
                            <span class="text-slate-400 block mb-1">البطاقة السابقة الملغاة:</span>
                            <span class="font-mono-num font-semibold text-rose-400">{{ $reissue->oldCard->card_uid }} (ملغاة أمنياً)</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-1">البطاقة البديلة الجديدة:</span>
                            @if($reissue->newCard)
                                <a href="{{ route('cards.verify', ['uid' => $reissue->newCard->card_uid]) }}" class="font-mono-num font-semibold text-emerald-400 hover:underline">
                                    {{ $reissue->newCard->card_uid }} (اضغط للفحص)
                                </a>
                            @else
                                <span class="text-slate-500 italic">لم تصدر بعد، قيد التجهيز</span>
                            @endif
                        </div>
                        @if($reissue->notes)
                            <div class="sm:col-span-2 p-3 rounded-xl bg-slate-900/70 border border-slate-800 text-slate-300">
                                <span class="font-bold text-slate-400 block mb-1">ملاحظات الطلب:</span>
                                {{ $reissue->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="glass-panel p-10 rounded-3xl text-center border border-slate-800 space-y-3">
                    <svg class="w-14 h-14 text-slate-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-base font-bold text-white">لا توجد طلبات إعادة إصدار مسجلة لهذا المعرّف</h3>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto">
                        تأكد من إدخال الرقم القومي الصحيح أو مراجعة إدارة شؤون البطاقات بالمؤسسة لتقديم طلب استبدال.
                    </p>
                </div>
            @endif
        </div>
    @endif

</div>
