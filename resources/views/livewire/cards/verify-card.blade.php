<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-10">

    <!-- Header Section -->
    <div class="text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-semibold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>بوابة الفحص والتحقق الأمني المباشر</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">التحقق من صحة البطاقة الذكية</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            قم بإدخال معرّف البطاقة (Card UID) أو امسح رمز الـ QR للتأكد الفوري من حالة السريان والبيانات المعتمدة رسمياً.
        </p>
    </div>

    <!-- Verification Search Box -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-2xl relative">
        <form wire:submit.prevent="verify" class="space-y-4">
            <div>
                <label for="scannedUid" class="block text-xs font-semibold text-slate-300 mb-2">
                    رمز البطاقة الذكية (UID / Card Identifier)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="scannedUid"
                        wire:model="scannedUid" 
                        placeholder="مثال: CARD-2026-0001 أو ULID..."
                        class="w-full pl-4 pr-11 py-3.5 bg-slate-900/90 text-white rounded-xl border {{ $errors->has('scannedUid') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm font-mono-num placeholder-slate-500 transition-all"
                    >
                </div>
                @error('scannedUid')
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
                    class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-cyan-400 text-slate-950 font-bold rounded-xl text-sm transition-all shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="verify" class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>بدء التحقق والتدقيق</span>
                    </span>
                    <span wire:loading wire:target="verify" class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-slate-950" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>جاري التدقيق في السجلات...</span>
                    </span>
                </button>

                @if($hasChecked)
                    <button 
                        type="button" 
                        wire:click="resetVerification" 
                        class="w-full sm:w-auto px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors"
                    >
                        مسح النتيجة وفحص أخرى
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Verification Results Area -->
    @if($hasChecked)
        <div class="space-y-8 animate-fadeIn">
            <!-- Result Badge & Status Notification -->
            @if($result === 'valid')
                <div class="p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/40">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-emerald-400">بطاقة صالحة ومطابقة رسمياً (VALID)</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-400 text-slate-950">معتمدة</span>
                        </div>
                        <p class="text-sm text-slate-300 mt-1">{{ $resultMessage }}</p>
                    </div>
                </div>
            @elseif($result === 'expired')
                <div class="p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center shrink-0 shadow-lg shadow-amber-500/40">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-amber-400">صلاحية البطاقة منتهية (EXPIRED)</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-400 text-slate-950">غير سارية</span>
                        </div>
                        <p class="text-sm text-slate-300 mt-1">{{ $resultMessage }}</p>
                    </div>
                </div>
            @elseif($result === 'revoked')
                <div class="p-5 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-rose-500/40">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-rose-400">بطاقة ملغاة ومسحوبة أمنياً (REVOKED)</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-500 text-white">تحذير أمني</span>
                        </div>
                        <p class="text-sm text-slate-300 mt-1">{{ $resultMessage }}</p>
                    </div>
                </div>
            @else
                <div class="p-5 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-rose-600/40">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-rose-400">بطاقة غير مسجلة أو مزورة (UNKNOWN)</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-600 text-white">مشبوهة</span>
                        </div>
                        <p class="text-sm text-slate-300 mt-1">{{ $resultMessage }}</p>
                    </div>
                </div>
            @endif

            <!-- Virtual Smart Card Preview (If Card Exists) -->
            @if($card)
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-200">معاينة بطاقة الهوية الرقمية (CR80 Standard):</span>
                        <span class="text-xs text-slate-400 font-mono-num">UID: {{ $card->card_uid }}</span>
                    </div>

                    <!-- CR80 Digital Card Container -->
                    <div class="max-w-xl mx-auto rounded-3xl p-6 sm:p-7 relative overflow-hidden shadow-2xl border border-slate-700/60 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
                        
                        <!-- Watermark Background -->
                        <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none">
                            <svg class="w-72 h-72 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>

                        <!-- Card Header: Organization & Chip -->
                        <div class="flex items-start justify-between border-b border-slate-700/60 pb-4 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-lg">
                                    {{ mb_substr($card->cardholder->organization->name_ar ?? 'H', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-white">{{ $card->cardholder->organization->name_ar ?? 'المؤسسة الوطنية' }}</h4>
                                    <p class="text-[11px] text-slate-400">{{ $card->cardholder->organization->name_en ?? 'National Organization' }}</p>
                                </div>
                            </div>

                            <!-- Smart Chip Graphic -->
                            <div class="w-11 h-8 rounded-lg bg-gradient-to-tr from-amber-400 via-yellow-200 to-amber-500 p-1 flex flex-col justify-between shadow-sm">
                                <div class="w-full h-1 bg-amber-600/30 rounded"></div>
                                <div class="w-full h-1 bg-amber-600/30 rounded"></div>
                                <div class="w-full h-1 bg-amber-600/30 rounded"></div>
                            </div>
                        </div>

                        <!-- Card Body: Photo & Info -->
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                            <!-- Photo -->
                            <div class="w-28 h-36 rounded-2xl bg-slate-800 border-2 border-emerald-500/40 overflow-hidden shrink-0 shadow-md flex items-center justify-center relative">
                                @if($card->cardholder->photo_path)
                                    <img src="{{ asset('storage/' . $card->cardholder->photo_path) }}" alt="Cardholder Photo" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center p-2 text-slate-400">
                                        <svg class="w-12 h-12 mx-auto text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-[10px] mt-1 block">صورة معتمدة</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-slate-900/80 text-[9px] font-bold text-emerald-400 font-mono-num">
                                    {{ $card->cardholder->blood_type ?? 'O+' }}
                                </div>
                            </div>

                            <!-- Details Table -->
                            <div class="flex-grow space-y-3 w-full">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">الاسم الكامل / Full Name</span>
                                    <h5 class="text-lg font-extrabold text-white leading-tight">{{ $card->cardholder->full_name_ar }}</h5>
                                    <p class="text-xs text-slate-400 font-medium">{{ $card->cardholder->full_name_en }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">الرقم القومي</span>
                                        <span class="font-mono-num text-slate-200 font-semibold">{{ $card->cardholder->national_id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">الرقم الوظيفي / الأكاديمي</span>
                                        <span class="font-mono-num text-slate-200 font-semibold">{{ $card->cardholder->employee_no ?? '---' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">القسم / الإدارة</span>
                                        <span class="text-slate-200 font-medium">{{ $card->cardholder->department->name_ar ?? 'العام' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">تاريخ الانتهاء</span>
                                        <span class="font-mono-num {{ $card->expires_at && $card->expires_at->isPast() ? 'text-rose-400 font-bold' : 'text-emerald-400 font-bold' }}">
                                            {{ $card->expires_at ? $card->expires_at->format('Y-m-d') : 'دائم (غير محدد)' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer: Barcode & Security Stamp -->
                        <div class="mt-6 pt-4 border-t border-slate-700/60 flex items-center justify-between text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $card->status->value === 'active' ? 'bg-emerald-400' : 'bg-rose-500' }}"></span>
                                <span>حالة البطاقة: <strong>{{ $card->status->getLabel() }}</strong></span>
                            </div>
                            <div class="font-mono-num text-[11px] text-slate-400">
                                إصدار: {{ $card->issued_at ? $card->issued_at->format('Y-m-d') : 'مبدئي' }} | طباعة: #{{ $card->print_count }}
                            </div>
                        </div>
                    </div>

                    <!-- Scan Audit Metadata -->
                    <div class="glass-panel p-4 rounded-xl text-xs text-slate-400 flex flex-wrap items-center justify-between gap-3 border border-slate-800">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>سجل الفحص: تم التوثيق بتاريخ <strong>{{ now()->format('Y-m-d H:i:s') }}</strong></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span>عنوان IP: <code class="text-slate-300 font-mono-num">{{ request()->ip() }}</code></span>
                            <span>•</span>
                            <span class="text-emerald-400 font-medium">سجل مدقق ومحمي</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

</div>
