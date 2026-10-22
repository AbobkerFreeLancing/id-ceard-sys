<x-filament-panels::page>
    <div class="space-y-6 max-w-5xl mx-auto">

        <!-- 1. Header Card: Ticket Info & Overview -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-6 space-y-4">
            
            <!-- Top Metadata Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 dark:border-gray-700 pb-4">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-black shadow-sm"
                          style="background-color: #0284c7 !important; color: #ffffff !important;">
                        {{ $record->ticket_number ?? ('#' . $record->id) }}
                    </span>


                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black shadow-sm"
                          style="background-color: {{ $record->status?->value === 'closed' ? '#ecfdf5' : ($record->status?->value === 'in_progress' ? '#fffbeb' : '#eff6ff') }} !important;
                                 color: {{ $record->status?->value === 'closed' ? '#047857' : ($record->status?->value === 'in_progress' ? '#b45309' : '#1d4ed8') }} !important;
                                 border: 1.5px solid {{ $record->status?->value === 'closed' ? '#6ee7b7' : ($record->status?->value === 'in_progress' ? '#fde68a' : '#93c5fd') }} !important;">
                        <span class="w-2 h-2 rounded-full ml-1.5 {{ $record->status?->value === 'closed' ? 'bg-emerald-500' : ($record->status?->value === 'in_progress' ? 'bg-amber-500' : 'bg-blue-500') }}"></span>
                        الحالة: {{ $record->status?->label() ?? 'مفتوحة' }}
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    @if($record->status?->value !== 'closed')
                        <button
                            type="button"
                            wire:click="closeTicket"
                            wire:confirm="هل أنت متأكد من رغبتك في إغلاق هذه التذكرة؟ يمكنك إعادة فتحها لاحقاً إذا احتجت."
                            class="inline-flex items-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition-all cursor-pointer"
                            style="background-color: #fef2f2 !important; color: #b91c1c !important; border: 1px solid #fecaca !important;"
                        >
                            <x-filament::icon icon="heroicon-m-check-badge" class="w-4 h-4 text-red-600" />
                            <span>إغلاق التذكرة</span>
                        </button>
                    @endif

                    <a
                        href="{{ \App\Filament\Student\Resources\Support\Tickets\StudentTicketResource::getUrl('index') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold py-2 px-3 rounded-xl transition-all"
                        style="background-color: #f8fafc !important; color: #475569 !important; border: 1px solid #e2e8f0 !important;"
                    >
                        <x-filament::icon icon="heroicon-m-arrow-right" class="w-4 h-4" />
                        <span>العودة للتذاكر</span>
                    </a>
                </div>
            </div>

            <!-- Title & Details -->
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white leading-snug">
                    {{ $record->title }}
                </h2>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-clock" class="w-4 h-4 text-slate-400" />
                    <span>تاريخ الفتح: {{ $record->created_at->format('Y-m-d H:i') }} ({{ $record->created_at->diffForHumans() }})</span>
                </div>
            </div>

            <!-- Description Box -->
            <div class="p-4 md:p-5 rounded-2xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700">
                <span class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-2">تفاصيل الطلب / المشكلة:</span>
                <div class="text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line font-medium">
                    {{ $record->description }}
                </div>

                @if($record->attachment)
                    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-gray-700">
                        <span class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-2">المرفق المرفوع مع الطلب:</span>
                        @php
                            $ext = strtolower(pathinfo($record->attachment, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                        @endphp

                        @if($isImage)
                            <div class="relative inline-block group">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($record->attachment) }}" target="_blank">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($record->attachment) }}"
                                         alt="المرفق"
                                         class="w-48 h-48 object-cover rounded-xl border border-slate-300 dark:border-gray-600 shadow-sm group-hover:opacity-90 transition-all" />
                                    <span class="text-[11px] font-bold text-primary-600 block mt-1">اضغط لعرض الصورة بالحجم الكامل &larr;</span>
                                </a>
                            </div>
                        @else
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($record->attachment) }}" target="_blank"
                               class="inline-flex items-center gap-2 text-xs font-bold px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 shadow-sm text-primary-600 hover:text-primary-700">
                                <x-filament::icon icon="heroicon-o-paper-clip" class="w-4 h-4" />
                                <span>تحميل المرفق ({{ $ext }})</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        <!-- 2. Replies Conversation Thread -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-chat-bubble-left-right" class="w-5 h-5 text-primary-600" />
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                        سجل المحادثة والردود
                    </h3>
                </div>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300">
                    {{ $record->replies()->where('is_internal_note', false)->count() }} ردود
                </span>
            </div>

            <div class="space-y-4">
                @forelse($record->replies()->where('is_internal_note', false)->oldest()->get() as $reply)
                    @php
                        $isStudent = ($reply->repliable_type === \Packages\University\Models\Student::class) || ($reply->repliable instanceof \Packages\University\Models\Student);
                    @endphp

                    <div class="flex flex-col {{ $isStudent ? 'items-end' : 'items-start' }}">
                        <div class="max-w-2xl w-full rounded-2xl p-4 shadow-sm border {{ $isStudent ? 'bg-blue-50/70 dark:bg-blue-950/30 border-blue-200 dark:border-blue-900' : 'bg-slate-50 dark:bg-gray-900/80 border-slate-200 dark:border-gray-700' }}">
                            
                            <!-- Header of Message -->
                            <div class="flex items-center justify-between gap-3 border-b {{ $isStudent ? 'border-blue-100 dark:border-blue-900/60' : 'border-slate-200 dark:border-gray-700' }} pb-2 mb-2.5">
                                <div class="flex items-center gap-2">
                                    @if($isStudent)
                                        <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-black shadow-sm">
                                            <x-filament::icon icon="heroicon-s-user" class="w-4 h-4 text-white" />
                                        </div>
                                        <div>
                                            <span class="text-xs font-black text-blue-950 dark:text-blue-300">أنت (الطالب)</span>
                                        </div>
                                    @else
                                        <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-black shadow-sm">
                                            <x-filament::icon icon="heroicon-s-lifebuoy" class="w-4 h-4 text-white" />
                                        </div>
                                        <div>
                                            <span class="text-xs font-black text-indigo-950 dark:text-indigo-300">فريق الدعم الفني</span>
                                            <span class="text-[10px] text-slate-500 font-semibold mr-1">({{ $reply->repliable?->name ?? 'الدعم الفني' }})</span>
                                        </div>
                                    @endif
                                </div>

                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $reply->created_at->format('Y-m-d H:i') }} ({{ $reply->created_at->diffForHumans() }})
                                </span>
                            </div>

                            <!-- Reply Body -->
                            <div class="text-xs md:text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line font-medium">
                                {{ $reply->reply }}
                            </div>

                            <!-- Reply Attachment if exists -->
                            @if($reply->attachment)
                                @php
                                    $repExt = strtolower(pathinfo($reply->attachment, PATHINFO_EXTENSION));
                                    $isRepImage = in_array($repExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                @endphp

                                <div class="mt-3 pt-3 border-t {{ $isStudent ? 'border-blue-100 dark:border-blue-900/60' : 'border-slate-200 dark:border-gray-700' }}">
                                    @if($isRepImage)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($reply->attachment) }}" target="_blank" class="inline-block">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($reply->attachment) }}" alt="مرفق" class="w-40 h-40 object-cover rounded-xl border border-slate-300 shadow-sm" />
                                            <span class="text-[10px] font-bold text-primary-600 block mt-0.5">عرض المرفق بالحجم الكامل &larr;</span>
                                        </a>
                                    @else
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($reply->attachment) }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 text-primary-600">
                                            <x-filament::icon icon="heroicon-o-paper-clip" class="w-4 h-4" />
                                            <span>تحميل الملف المرفق</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 px-4 rounded-2xl bg-slate-50 dark:bg-gray-900/40 border border-dashed border-slate-200 dark:border-gray-700">
                        <x-filament::icon icon="heroicon-o-clock" class="w-8 h-8 text-slate-400 mx-auto mb-2" />
                        <h4 class="text-sm font-extrabold text-slate-800 dark:text-slate-200">في انتظار رد الدعم الفني</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1">
                            طلبك مسجل لدى قسم الدعم الفني وسيتم الرد عليك هنا قريباً. يمكنك أيضاً إضافة أي تفاصيل إضافية في النموذج أدناه.
                        </p>
                    </div>
                @endforelse
            </div>

        </div>

        <!-- 3. Send Reply Box -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-6 space-y-4">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-paper-airplane" class="w-5 h-5 text-primary-600" />
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                        إرسال رد جديد للدعم الفني
                    </h3>
                </div>
                @if($record->status?->value === 'closed')
                    <span class="text-xs font-bold text-amber-600 dark:text-amber-400">
                        ملاحظة: إرسال رد جديد سيعيد فتح التذكرة تلقائياً
                    </span>
                @endif
            </div>

            <form wire:submit.prevent="sendReply" class="space-y-4">
                
                <div>
                    <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                        نص الرد <span class="text-rose-600 font-black">*</span>
                    </label>
                    <textarea
                        wire:model="replyMessage"
                        rows="4"
                        placeholder="اكتب ردك أو استفسارك الإضافي هنا..."
                        class="w-full text-xs md:text-sm font-medium rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 p-3 @error('replyMessage') border-rose-500 ring-1 ring-rose-500 @enderror"
                    ></textarea>
                    @error('replyMessage')
                        <span class="text-[11px] font-bold text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1">
                            إرفاق صورة أو مستند إضافي (اختياري)
                        </label>
                        <input
                            type="file"
                            wire:model="replyAttachment"
                            class="block w-full text-xs text-slate-600 file:ml-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-gray-700 dark:file:text-white cursor-pointer"
                        />
                        @error('replyAttachment')
                            <span class="text-[11px] font-bold text-rose-600 mt-1 block">{{ $message }}</span>
                        @enderror

                        <div wire:loading wire:target="replyAttachment" class="text-xs font-bold text-primary-600 mt-1">
                            جاري رفع الملف...
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center gap-2 font-black py-3 px-8 rounded-xl shadow-md hover:shadow-lg text-sm transition-all duration-200 cursor-pointer disabled:opacity-50"
                            style="background-color: #0284c7 !important; color: #ffffff !important; border: 1.5px solid #0369a1 !important;"
                        >
                            <x-filament::icon icon="heroicon-o-paper-airplane" class="w-4 h-4 text-white" />
                            <span wire:loading.remove wire:target="sendReply">إرسال الرد للدعم الفني</span>
                            <span wire:loading wire:target="sendReply">جاري الإرسال...</span>
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</x-filament-panels::page>
