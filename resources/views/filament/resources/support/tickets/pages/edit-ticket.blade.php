<x-filament-panels::page>
    @if($record->is_from_student && $record->student)
        @php
            $student = $record->student;
        @endphp

        <div class="space-y-6">

            <!-- ======================================================== -->
            <!-- 1. TOP HEADER BAR: TICKET OVERVIEW & STATUS CONTROLS      -->
            <!-- ======================================================== -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-5">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Right side: Student & Ticket info -->
                    <div class="flex items-center gap-3.5">
                        <img
                            src="{{ $student->profile_picture_url }}"
                            alt="{{ $student->name }}"
                            class="w-14 h-14 rounded-2xl object-cover border-2 border-primary-500 shadow-sm flex-shrink-0"
                        />
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-black shadow-sm"
                                      style="background-color: #0284c7 !important; color: #ffffff !important;">
                                    {{ $record->ticket_number ?? ('#' . $record->id) }}
                                </span>
                                <h3 class="text-base md:text-lg font-black text-slate-900 dark:text-white">
                                    {{ $student->name }}
                                </h3>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                    طالب
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400 font-semibold">
                                <span>الرقم الجامعي: <strong class="text-slate-800 dark:text-slate-200">{{ $student->university_no ?? '—' }}</strong></span>
                                <span>•</span>
                                <span>الرقم الوطني: <strong class="text-slate-800 dark:text-slate-200">{{ $student->national_id_number ?? '—' }}</strong></span>
                                <span>•</span>
                                <span>الكلية: <strong class="text-slate-800 dark:text-slate-200">{{ $student->academicRecord?->college?->name ?? 'جامعة العلوم الصحية' }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Left side: Quick Status Buttons & External Link -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <div class="flex items-center bg-slate-100 dark:bg-gray-900 p-1.5 rounded-xl border border-slate-200 dark:border-gray-700">
                            <!-- Open Button -->
                            <button
                                type="button"
                                wire:click="setTicketStatus('open')"
                                class="px-3 py-1.5 rounded-lg text-xs font-black transition-all cursor-pointer flex items-center gap-1.5 {{ $record->status?->value === 'open' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                style="{{ $record->status?->value === 'open' ? 'background-color: #0284c7 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                            >
                                <span class="w-2 h-2 rounded-full {{ $record->status?->value === 'open' ? 'bg-white' : 'bg-blue-500' }}"></span>
                                مفتوحة
                            </button>

                            <!-- In Progress Button -->
                            <button
                                type="button"
                                wire:click="setTicketStatus('in_progress')"
                                class="px-3 py-1.5 rounded-lg text-xs font-black transition-all cursor-pointer flex items-center gap-1.5 {{ $record->status?->value === 'in_progress' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                style="{{ $record->status?->value === 'in_progress' ? 'background-color: #d97706 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                            >
                                <span class="w-2 h-2 rounded-full {{ $record->status?->value === 'in_progress' ? 'bg-white' : 'bg-amber-500' }}"></span>
                                قيد المعالجة
                            </button>

                            <!-- Closed Button -->
                            <button
                                type="button"
                                wire:click="setTicketStatus('closed')"
                                class="px-3 py-1.5 rounded-lg text-xs font-black transition-all cursor-pointer flex items-center gap-1.5 {{ $record->status?->value === 'closed' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                style="{{ $record->status?->value === 'closed' ? 'background-color: #059669 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                            >
                                <span class="w-2 h-2 rounded-full {{ $record->status?->value === 'closed' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                                مغلقة
                            </button>
                        </div>

                        <a
                            href="{{ route('filament.admin.resources.university.students.view', ['record' => $student]) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 text-xs font-bold py-2.5 px-3.5 rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-700 dark:text-slate-200 hover:text-primary-600 transition-all shadow-sm"
                        >
                            <x-filament::icon icon="heroicon-o-academic-cap" class="w-4 h-4 text-primary-600" />
                            <span>الملف الأكاديمي</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 2. TWO COLUMNS GRID: REQUEST & ATTACHMENTS vs EDITOR     -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- ==================================================== -->
                <!-- COLUMN 1: STUDENT REQUEST DETAILS & ATTACHMENTS (5/12) -->
                <!-- ==================================================== -->
                <div class="lg:col-span-5 space-y-5">
                    
                    <!-- Ticket Content Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-5 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-3">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-document-text" class="w-5 h-5 text-primary-600" />
                                <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                    طلب وموضوع التذكرة
                                </h4>
                            </div>
                            <span class="text-[11px] text-slate-400 font-semibold">
                                {{ $record->created_at->format('Y-m-d H:i') }}
                            </span>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-slate-400 mb-1">موضوع التذكرة:</span>
                            <h3 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                                {{ $record->title }}
                            </h3>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-slate-400 mb-1">شرح الطالب للطلب / المشكلة:</span>
                            <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700 text-xs md:text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line font-medium">
                                {{ $record->description }}
                            </div>
                        </div>
                    </div>

                    <!-- ==================================================== -->
                    <!-- Student's Attached Files & Photos Gallery Card       -->
                    <!-- ==================================================== -->
                    @php
                        $studentAttachments = $record->getStudentAttachments();
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-5 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-3">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-photo" class="w-5 h-5 text-indigo-600" />
                                <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                    معرض الصور والمرفقات المرسلة من الطالب ({{ count($studentAttachments) }})
                                </h4>
                            </div>
                            @if(count($studentAttachments) > 0)
                                <span class="px-2 py-0.5 rounded text-[10px] font-black bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300">
                                    {{ count($studentAttachments) }} مرفق
                                </span>
                            @endif
                        </div>

                        @if(count($studentAttachments) > 0)
                            <div class="space-y-4">
                                @foreach($studentAttachments as $attIdx => $att)
                                    @php
                                        $fileUrl = $att['data_uri'] ?? $att['url'];
                                        $downloadUrl = $att['url'];
                                        $isImg = $att['is_image'];
                                        $filePath = $att['path'];
                                        $ext = strtoupper($att['extension']);
                                    @endphp

                                    <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700 space-y-3">
                                        <!-- Header for this attachment -->
                                        <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-200 dark:border-gray-700">
                                            <div class="flex items-center gap-1.5 font-black text-slate-800 dark:text-slate-200">
                                                <span class="w-5 h-5 rounded-md bg-indigo-600 text-white flex items-center justify-center text-[10px]">#{{ $attIdx + 1 }}</span>
                                                <span>{{ $att['source'] }}</span>
                                            </div>
                                            <span class="text-[10px] text-slate-400 font-semibold">
                                                {{ $att['created_at']->format('Y-m-d H:i') }}
                                            </span>
                                        </div>

                                        <!-- Preview -->
                                        @if($isImg)
                                            <div class="p-2 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 flex justify-center">
                                                <a href="{{ $downloadUrl }}" target="_blank" title="اضغط للتكبير وعرض الصورة بالحجم الكامل">
                                                    <img
                                                        src="{{ $fileUrl }}"
                                                        alt="مرفق الطالب"
                                                        class="max-h-56 object-contain rounded-lg shadow-sm hover:scale-[1.02] transition-all cursor-pointer"
                                                    />
                                                </a>
                                            </div>
                                        @else
                                            <div class="p-4 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-center space-y-2">
                                                <x-filament::icon icon="heroicon-o-document" class="w-10 h-10 text-slate-400 mx-auto" />
                                                <span class="block text-xs font-bold text-slate-700 dark:text-slate-300">مستند ملف مرفق ({{ $ext }})</span>
                                            </div>
                                        @endif

                                        <!-- Quick Adoption Action Buttons -->
                                        <div class="space-y-1.5 pt-1">
                                            <span class="block text-[11px] font-black text-slate-500 mb-1">إجراءات اعتماد المرفق في ملف الطالب:</span>
                                            
                                            <!-- Option 1: Profile picture -->
                                            <button
                                                type="button"
                                                wire:click="applyAttachmentAsProfilePicture('{{ addslashes($filePath) }}')"
                                                wire:confirm="هل تريد اعتماد هذه الصورة كصورة شخصية رسمية لملف الطالب؟ ستظهر في بطاقته وسجله الأكاديمي فوراً."
                                                class="w-full inline-flex items-center justify-center gap-2 font-black py-2 px-3 rounded-xl text-xs shadow-sm hover:shadow transition-all cursor-pointer"
                                                style="background-color: #059669 !important; color: #ffffff !important; border: 1.5px solid #047857 !important;"
                                            >
                                                <x-filament::icon icon="heroicon-s-check-badge" class="w-4 h-4 text-white" />
                                                <span>اعتماد كصورة شخصية رسمية للطالب</span>
                                            </button>

                                            <!-- Option 2: Identity proof -->
                                            <button
                                                type="button"
                                                wire:click="applyAttachmentAsIdentityProof('{{ addslashes($filePath) }}')"
                                                wire:confirm="هل تريد اعتماد هذا المرفق كمستند إثبات شخصية (الرقم الوطني) في ملف الطالب؟"
                                                class="w-full inline-flex items-center justify-center gap-2 font-black py-2 px-3 rounded-xl text-xs shadow-sm hover:shadow transition-all cursor-pointer"
                                                style="background-color: #0284c7 !important; color: #ffffff !important; border: 1.5px solid #0369a1 !important;"
                                            >
                                                <x-filament::icon icon="heroicon-s-identification" class="w-4 h-4 text-white" />
                                                <span>اعتماد كمستند إثبات شخصية (الرقم الوطني)</span>
                                            </button>

                                            <!-- Option 3: Sudanese Certificate -->
                                            <button
                                                type="button"
                                                wire:click="applyAttachmentAsSudaneseCertificate('{{ addslashes($filePath) }}')"
                                                wire:confirm="هل تريد اعتماد هذا المرفق كمستند الشهادة السودانية (الثانوية) في ملف الطالب؟"
                                                class="w-full inline-flex items-center justify-center gap-2 font-black py-2 px-3 rounded-xl text-xs shadow-sm hover:shadow transition-all cursor-pointer"
                                                style="background-color: #7c3aed !important; color: #ffffff !important; border: 1.5px solid #6d28d9 !important;"
                                            >
                                                <x-filament::icon icon="heroicon-s-academic-cap" class="w-4 h-4 text-white" />
                                                <span>اعتماد كمستند الشهادة السودانية (الثانوية)</span>
                                            </button>

                                            <div class="flex items-center gap-2 pt-1">
                                                <a
                                                    href="{{ $fileUrl }}"
                                                    target="_blank"
                                                    class="flex-1 inline-flex items-center justify-center gap-1.5 font-bold py-1.5 px-3 rounded-lg text-[11px] bg-slate-200 hover:bg-slate-300 text-slate-800 transition-all text-center"
                                                >
                                                    <x-filament::icon icon="heroicon-o-eye" class="w-3.5 h-3.5 text-slate-600" />
                                                    <span>معاينة كاملة</span>
                                                </a>

                                                <a
                                                    href="{{ $fileUrl }}"
                                                    target="_blank"
                                                    download
                                                    class="flex-1 inline-flex items-center justify-center gap-1.5 font-bold py-1.5 px-3 rounded-lg text-[11px] bg-slate-200 hover:bg-slate-300 text-slate-800 transition-all text-center"
                                                >
                                                    <x-filament::icon icon="heroicon-o-arrow-down-tray" class="w-3.5 h-3.5 text-slate-600" />
                                                    <span>تحميل المرفق</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-8 text-center text-slate-400">
                                <x-filament::icon icon="heroicon-o-no-symbol" class="w-8 h-8 mx-auto mb-1 opacity-50" />
                                <span class="text-xs font-medium">لم يرفق الطالب أي مستند أو صورة مع هذه التذكرة.</span>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- COLUMN 2: DIRECT STUDENT DATA & PHOTO EDITOR (7/12)   -->
                <!-- ==================================================== -->
                <div class="lg:col-span-7 space-y-5">
                    
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-5 space-y-5">
                        
                        <!-- Header with Navigation Tabs -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-gray-700 pb-3">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-pencil-square" class="w-5 h-5 text-emerald-600" />
                                <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                    تعديل بيانات وصور ومستندات الطالب مباشرة
                                </h4>
                            </div>

                            <!-- Tabs Switcher -->
                            <div class="flex items-center gap-1 bg-slate-100 dark:bg-gray-900 p-1 rounded-xl">
                                <button
                                    type="button"
                                    wire:click="setActiveTab('photo_docs')"
                                    class="px-2.5 py-1 rounded-lg text-xs font-extrabold transition-all cursor-pointer {{ $activeTab === 'photo_docs' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                    style="{{ $activeTab === 'photo_docs' ? 'background-color: #0284c7 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                                >
                                    الصورة والوثائق
                                </button>
                                <button
                                    type="button"
                                    wire:click="setActiveTab('personal_info')"
                                    class="px-2.5 py-1 rounded-lg text-xs font-extrabold transition-all cursor-pointer {{ $activeTab === 'personal_info' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                    style="{{ $activeTab === 'personal_info' ? 'background-color: #0284c7 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                                >
                                    البيانات الشخصية
                                </button>
                                <button
                                    type="button"
                                    wire:click="setActiveTab('guardian_info')"
                                    class="px-2.5 py-1 rounded-lg text-xs font-extrabold transition-all cursor-pointer {{ $activeTab === 'guardian_info' ? 'shadow-sm' : 'opacity-60 hover:opacity-100' }}"
                                    style="{{ $activeTab === 'guardian_info' ? 'background-color: #0284c7 !important; color: #ffffff !important;' : 'color: #334155;' }}"
                                >
                                    بيانات ولي الأمر
                                </button>
                            </div>
                        </div>

                        <!-- TAB 1: Photo & Documents Management -->
                        @if($activeTab === 'photo_docs')
                            <div class="space-y-5">
                                
                                <!-- Profile Picture Comparison & Uploader -->
                                <div class="p-4 rounded-xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700">
                                    <span class="block text-xs font-black text-slate-800 dark:text-slate-200 mb-3">
                                        الصورة الشخصية الرسمية للطالب بالنظام:
                                    </span>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                                        <!-- Current Photo -->
                                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                            <img
                                                src="{{ $student->profile_picture_url }}"
                                                alt="الصورة الحالية"
                                                class="w-16 h-16 rounded-xl object-cover border border-slate-300 shadow-sm flex-shrink-0"
                                            />
                                            <div>
                                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block">الصورة الحالية المعتمدة</span>
                                                <span class="text-[10px] text-slate-400 block mt-0.5">تظهر في بطاقة الطالب والشهادات</span>
                                            </div>
                                        </div>

                                        <!-- Upload New Photo Directly -->
                                        <div>
                                            <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">
                                                رفع صورة جديدة مباشرة:
                                            </label>
                                            <input
                                                type="file"
                                                wire:model="new_profile_picture"
                                                accept="image/*"
                                                class="block w-full text-xs text-slate-600 file:ml-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-primary-100 file:text-primary-800 hover:file:bg-primary-200 cursor-pointer"
                                            />
                                            <div wire:loading wire:target="new_profile_picture" class="text-[11px] font-bold text-primary-600 mt-1">
                                                جاري تحميل الصورة...
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Student Documents List -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-800 dark:text-slate-200">
                                            مستندات ووثائق الطالب المرفوعة ({{ $student->identities->count() }}):
                                        </span>
                                    </div>

                                    @if($student->identities->count() > 0)
                                        <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                            @foreach($student->identities as $doc)
                                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-700 flex items-center justify-between text-xs">
                                                    <div class="flex items-center gap-2">
                                                        <x-filament::icon icon="heroicon-o-document-check" class="w-4 h-4 text-emerald-600" />
                                                        <div>
                                                            <strong class="text-slate-800 dark:text-slate-200 font-bold">{{ $doc->type?->getLabel() ?? 'مستند' }}</strong>
                                                            @if($doc->number)
                                                                <span class="text-[10px] text-slate-500 mr-1">({{ $doc->number }})</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-1.5">
                                                        @if($doc->attachment)
                                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($doc->attachment) }}" target="_blank" class="px-2 py-1 rounded bg-slate-200 text-slate-700 text-[10px] font-bold">
                                                                معاينة
                                                            </a>
                                                        @endif
                                                        <button
                                                            type="button"
                                                            wire:click="deleteStudentDocument({{ $doc->id }})"
                                                            wire:confirm="هل أنت متأكد من حذف هذا المستند؟"
                                                            class="px-2 py-1 rounded bg-red-100 text-red-700 text-[10px] font-bold cursor-pointer"
                                                        >
                                                            حذف
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="p-3 text-center rounded-xl bg-slate-50 dark:bg-gray-900/40 text-xs text-slate-400">
                                            لا توجد مستندات إضافية مسجلة في ملف الطالب.
                                        </div>
                                    @endif
                                </div>

                                <!-- Add New Document Form -->
                                <div class="p-3.5 rounded-xl bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-200 dark:border-indigo-900/60 space-y-3">
                                    <span class="block text-xs font-black text-indigo-950 dark:text-indigo-300">
                                        + إضافة مستند / وثيقة جديدة للطالب:
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-600 mb-0.5">نوع المستند</label>
                                            <select wire:model="doc_type" class="w-full text-xs font-semibold rounded-lg border-slate-300 py-1.5">
                                                @foreach(\Packages\University\Enums\IdentityTypeEnum::getOptions() as $val => $lbl)
                                                    <option value="{{ $val }}">{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-600 mb-0.5">رقم المستند / الوثيقة</label>
                                            <input type="text" wire:model="doc_number" placeholder="مثال: 12345678" class="w-full text-xs rounded-lg border-slate-300 py-1.5" />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-600 mb-0.5">الملف / الصورة</label>
                                            <input type="file" wire:model="doc_file" class="block w-full text-[10px] text-slate-600 file:ml-1 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-indigo-100 file:text-indigo-800" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-1">
                                        <button
                                            type="button"
                                            wire:click="uploadNewStudentDocument"
                                            class="px-3 py-1.5 rounded-lg text-xs font-black bg-indigo-600 hover:bg-indigo-700 text-white transition-all cursor-pointer shadow-sm"
                                        >
                                            حفظ وإضافة المستند
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endif

                        <!-- TAB 2: Personal Info Inputs -->
                        @if($activeTab === 'personal_info')
                            <div class="space-y-4">
                                <!-- 4 Names in Arabic -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الاسم الأول *</label>
                                        <input type="text" wire:model="student_first_name" class="w-full text-xs md:text-sm font-bold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الاسم الثاني *</label>
                                        <input type="text" wire:model="student_second_name" class="w-full text-xs md:text-sm font-bold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الاسم الثالث *</label>
                                        <input type="text" wire:model="student_third_name" class="w-full text-xs md:text-sm font-bold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الاسم الرابع *</label>
                                        <input type="text" wire:model="student_fourth_name" class="w-full text-xs md:text-sm font-bold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الاسم بالإنجليزية (Full Name EN)</label>
                                        <input type="text" wire:model="student_full_name_en" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الرقم الوطني</label>
                                        <input type="text" wire:model="student_national_id_number" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">رقم الهاتف</label>
                                        <input type="text" wire:model="student_phone" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">الجنس</label>
                                        <select wire:model="student_gender" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5">
                                            @foreach(\Packages\Enum\Profile\GenderEnum::getOptions() as $val => $lbl)
                                                <option value="{{ $val }}">{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">تاريخ الميلاد</label>
                                        <input type="date" wire:model="student_date_of_birth" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">العنوان الحالي</label>
                                        <input type="text" wire:model="student_address" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">العنوان الدائم</label>
                                        <input type="text" wire:model="student_permanent_address" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- TAB 3: Guardian Info Inputs -->
                        @if($activeTab === 'guardian_info')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">اسم ولي الأمر</label>
                                    <input type="text" wire:model="student_guardian_name" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">هاتف ولي الأمر</label>
                                    <input type="text" wire:model="student_guardian_phone" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">صلة القرابة</label>
                                    <input type="text" wire:model="student_guardian_relationship" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-300 mb-1">وظيفة ولي الأمر</label>
                                    <input type="text" wire:model="student_guardian_job" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 p-2.5" />
                                </div>
                            </div>
                        @endif

                        <!-- DIRECT SAVE BUTTON (Saves all student modifications) -->
                        <div class="pt-3 border-t border-slate-100 dark:border-gray-700 flex justify-end">
                            <button
                                type="button"
                                wire:click="saveStudentInfo"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center gap-2 font-black py-3 px-8 rounded-xl shadow-md hover:shadow-lg text-sm transition-all duration-200 cursor-pointer"
                                style="background-color: #059669 !important; color: #ffffff !important; border: 1.5px solid #047857 !important;"
                            >
                                <x-filament::icon icon="heroicon-s-check" class="w-5 h-5 text-white" />
                                <span wire:loading.remove wire:target="saveStudentInfo">حفظ وتحديث بيانات الطالب في النظام فوراً</span>
                                <span wire:loading wire:target="saveStudentInfo">جاري الحفظ والتحديث...</span>
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            <!-- ======================================================== -->
            <!-- 3. BOTTOM SECTION: CHAT THREAD & REPLY TO STUDENT         -->
            <!-- ======================================================== -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-6 space-y-5">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-3">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-chat-bubble-left-right" class="w-5 h-5 text-primary-600" />
                        <h4 class="text-base font-black text-slate-900 dark:text-white">
                            سجل المحادثة والردود على التذكرة ({{ $record->replies->count() }})
                        </h4>
                    </div>
                </div>

                <!-- Replies Thread -->
                <div class="space-y-4">
                    @forelse($record->replies()->oldest()->get() as $reply)
                        @php
                            $isFromStudent = ($reply->repliable_type === \Packages\University\Models\Student::class) || ($reply->repliable instanceof \Packages\University\Models\Student);
                        @endphp

                        <div class="flex flex-col {{ $isFromStudent ? 'items-start' : 'items-end' }}">
                            <div class="max-w-2xl w-full rounded-2xl p-4 shadow-sm border {{ $isFromStudent ? 'bg-blue-50/70 border-blue-200' : ($reply->is_internal_note ? 'bg-amber-50/80 border-amber-300' : 'bg-slate-50 border-slate-200') }}">
                                
                                <div class="flex items-center justify-between gap-3 border-b pb-2 mb-2 {{ $isFromStudent ? 'border-blue-200' : 'border-slate-200' }}">
                                    <div class="flex items-center gap-2">
                                        @if($isFromStudent)
                                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                            <span class="text-xs font-black text-blue-900">{{ $reply->repliable?->name ?? 'الطالب' }} (طالب)</span>
                                        @else
                                            <span class="w-2.5 h-2.5 rounded-full {{ $reply->is_internal_note ? 'bg-amber-500' : 'bg-indigo-600' }}"></span>
                                            <span class="text-xs font-black {{ $reply->is_internal_note ? 'text-amber-900' : 'text-indigo-900' }}">
                                                {{ $reply->repliable?->name ?? 'الدعم الفني' }}
                                                @if($reply->is_internal_note)
                                                    <span class="text-[10px] bg-amber-200 text-amber-900 px-1.5 py-0.5 rounded font-black mr-1">ملاحظة داخلية</span>
                                                @else
                                                    <span class="text-[10px] bg-indigo-200 text-indigo-900 px-1.5 py-0.5 rounded font-black mr-1">الدعم الفني</span>
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-semibold">
                                        {{ $reply->created_at->format('Y-m-d H:i') }} ({{ $reply->created_at->diffForHumans() }})
                                    </span>
                                </div>

                                <div class="text-xs md:text-sm text-slate-800 leading-relaxed whitespace-pre-line font-medium">
                                    {{ $reply->reply }}
                                </div>

                                @if($reply->attachment)
                                    @php
                                        $repExt = strtolower(pathinfo($reply->attachment, PATHINFO_EXTENSION));
                                        $isRepImg = in_array($repExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                    @endphp
                                    <div class="mt-2.5 pt-2 border-t border-slate-200/60 space-y-2">
                                        @if($isRepImg)
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($reply->attachment) }}" target="_blank">
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($reply->attachment) }}" class="w-32 h-32 object-cover rounded-lg border border-slate-300 hover:opacity-95 transition-all" />
                                            </a>
                                        @else
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($reply->attachment) }}" target="_blank" class="text-xs font-bold text-primary-600">
                                                تحميل المرفق ({{ $repExt }})
                                            </a>
                                        @endif

                                        @if($isFromStudent)
                                            <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                                <button
                                                    type="button"
                                                    wire:click="applyAttachmentAsProfilePicture('{{ addslashes($reply->attachment) }}')"
                                                    wire:confirm="اعتماد هذه الصورة كصورة شخصية رسمية للطالب؟"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all cursor-pointer"
                                                >
                                                    <x-filament::icon icon="heroicon-s-check-badge" class="w-3.5 h-3.5 text-white" />
                                                    <span>صورة شخصية</span>
                                                </button>

                                                <button
                                                    type="button"
                                                    wire:click="applyAttachmentAsIdentityProof('{{ addslashes($reply->attachment) }}')"
                                                    wire:confirm="اعتماد هذا المرفق كمستند إثبات شخصية (الرقم الوطني) للطالب؟"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black text-white bg-sky-600 hover:bg-sky-700 shadow-sm transition-all cursor-pointer"
                                                >
                                                    <x-filament::icon icon="heroicon-s-identification" class="w-3.5 h-3.5 text-white" />
                                                    <span>إثبات شخصية</span>
                                                </button>

                                                <button
                                                    type="button"
                                                    wire:click="applyAttachmentAsSudaneseCertificate('{{ addslashes($reply->attachment) }}')"
                                                    wire:confirm="اعتماد هذا المرفق كمستند الشهادة السودانية (الثانوية) للطالب؟"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black text-white bg-purple-600 hover:bg-purple-700 shadow-sm transition-all cursor-pointer"
                                                >
                                                    <x-filament::icon icon="heroicon-s-academic-cap" class="w-3.5 h-3.5 text-white" />
                                                    <span>شهادة سودانية</span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            لا توجد ردود بعد على هذه التذكرة. يمكنك كتابة الرد الأول للطالب أدناه.
                        </div>
                    @endforelse
                </div>

                <!-- Reply Form -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-700 space-y-3">
                    <span class="block text-xs font-black text-slate-800 dark:text-slate-200">
                        كتابة وإرسال رد جديد للطالب:
                    </span>

                    <textarea
                        wire:model="reply_message"
                        rows="3"
                        placeholder="اكتب ردك أو التوجيه للطالب هنا (مثال: تم اعتماد الصورة والبيانات الجديدة بنجاح، يمكنك تسجيل الدخول والتحقق)..."
                        class="w-full text-xs md:text-sm font-medium rounded-xl border-slate-300 p-3"
                    ></textarea>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <input
                                type="file"
                                wire:model="reply_attachment"
                                class="text-xs text-slate-600 file:ml-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-slate-200 cursor-pointer"
                            />

                            <label class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model="is_internal_note" class="rounded border-slate-300 text-amber-600" />
                                <span>ملاحظة داخلية خاصة بفريق الدعم (لا تظهر للطالب)</span>
                            </label>
                        </div>

                        <button
                            type="button"
                            wire:click="sendReply"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center gap-2 font-black py-2.5 px-6 rounded-xl shadow-md text-xs transition-all cursor-pointer"
                            style="background-color: #0284c7 !important; color: #ffffff !important;"
                        >
                            <x-filament::icon icon="heroicon-o-paper-airplane" class="w-4 h-4 text-white" />
                            <span wire:loading.remove wire:target="sendReply">إرسال الرد</span>
                            <span wire:loading wire:target="sendReply">جاري الإرسال...</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    @else
        <!-- Fallback for generic non-student tickets -->
        <x-filament-panels::form wire:submit="save">
            {{ $this->form }}
            <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" />
        </x-filament-panels::form>
    @endif
</x-filament-panels::page>
