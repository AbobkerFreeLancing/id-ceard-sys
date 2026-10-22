<x-filament-panels::page>
    <div class="space-y-6 max-w-7xl mx-auto">

        <!-- Stepper Progress Bar (شريط تتبع المراحل) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 p-5 transition-all">
            <div class="flex items-center justify-between max-w-3xl mx-auto relative">
                
                <!-- Step 1 -->
                <div class="flex items-center gap-3 z-10">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-base shadow-sm transition-all duration-300 {{ $step >= 1 ? 'bg-primary-600 text-white shadow-primary-500/20' : 'bg-slate-100 text-slate-500 dark:bg-gray-700 dark:text-gray-400' }}">
                        @if($step > 1)
                            <x-filament::icon icon="heroicon-m-check" class="w-6 h-6 text-white" />
                        @else
                            1
                        @endif
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white">رفع الملف والبيانات</div>
                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400">تحديد الملف والتوزيع الأكاديمي</div>
                    </div>
                </div>

                <!-- Connector Line 1 -->
                <div class="h-1 flex-1 mx-4 rounded-full transition-all duration-500 {{ $step >= 2 ? 'bg-primary-600' : 'bg-slate-200 dark:bg-gray-700' }}"></div>

                <!-- Step 2 -->
                <div class="flex items-center gap-3 z-10">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-base shadow-sm transition-all duration-300 {{ $step >= 2 ? ($step > 2 ? 'bg-primary-600 text-white' : 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-primary-950') : 'bg-slate-100 text-slate-500 dark:bg-gray-700 dark:text-gray-400' }}">
                        @if($step > 2)
                            <x-filament::icon icon="heroicon-m-check" class="w-6 h-6 text-white" />
                        @else
                            2
                        @endif
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white">معاينة وتدقيق البيانات</div>
                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400">فحص التكرارات والاستخراج</div>
                    </div>
                </div>

                <!-- Connector Line 2 -->
                <div class="h-1 flex-1 mx-4 rounded-full transition-all duration-500 {{ $step >= 3 ? 'bg-emerald-600' : 'bg-slate-200 dark:bg-gray-700' }}"></div>

                <!-- Step 3 -->
                <div class="flex items-center gap-3 z-10">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-base shadow-sm transition-all duration-300 {{ $step == 3 ? 'bg-emerald-600 text-white shadow-emerald-500/25 ring-4 ring-emerald-100 dark:ring-emerald-950' : 'bg-slate-100 text-slate-500 dark:bg-gray-700 dark:text-gray-400' }}">
                        @if($step == 3)
                            <x-filament::icon icon="heroicon-m-check" class="w-6 h-6 text-white" />
                        @else
                            3
                        @endif
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white">الحفظ والإتمام</div>
                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400">إضافة الطلاب إلى النظام</div>
                    </div>
                </div>
            </div>
        </div>

        @if($step === 1)
            <!-- ========================================== -->
            <!-- STEP 1: Upload & Academic Settings        -->
            <!-- ========================================== -->
            <div class="space-y-6">

                <!-- 1. Academic Settings Card (إلزامي قبل رفع الكشف) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-4 mb-5 gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shadow-sm">
                                <x-filament::icon icon="heroicon-o-academic-cap" class="w-6 h-6" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-base font-extrabold text-slate-900 dark:text-white">
                                        الخطوة الأولى: تحديد البيانات الأكاديمية للدفعة
                                    </h4>
                                    <span class="text-[11px] font-black px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-950/80 dark:text-rose-300 border border-rose-200 dark:border-rose-900">
                                        إلزامي قبل رفع الكشف
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    يجب اختيار الكلية والقسم والعام الأكاديمي والبيانات الأساسية لتطبيقها آلياً على طلاب الكشف
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 6 Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- 1. College -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                الكلية <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model.live="college_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('college_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <option value="">-- اختر الكلية --</option>
                                @foreach(\Packages\University\Models\College::all() as $col)
                                    <option value="{{ $col->id }}">{{ $col->name }}</option>
                                @endforeach
                            </select>
                            @error('college_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 2. Department -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                القسم الأكاديمي <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model="department_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('department_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <option value="">-- اختر القسم --</option>
                                @foreach(\Packages\University\Models\Department::when($college_id, fn($q) => $q->where('college_id', $college_id))->get() as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 3. Academic Year -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                العام الأكاديمي <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model="academic_year_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('academic_year_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <option value="">-- اختر العام الأكاديمي --</option>
                                @foreach(\Packages\University\Models\AcademicYear::all() as $ay)
                                    <option value="{{ $ay->id }}">{{ $ay->name }}</option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 4. Batch -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                الدفعة الدراسية <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model="batch_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('batch_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <option value="">-- اختر الدفعة --</option>
                                @foreach(\Packages\University\Models\Batch::when($college_id, fn($q) => $q->where('college_id', $college_id))->get() as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 5. Level -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                المستوى الدراسي <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model="level_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('level_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                @foreach(\Packages\University\Models\Level::query()->orderBy('sort_order')->get() as $lvl)
                                    <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 6. Acceptance Type -->
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">
                                نوع القبول <span class="text-rose-600 font-black">*</span>
                            </label>
                            <select wire:model="acceptance_type_id" class="w-full text-xs md:text-sm font-semibold rounded-xl border-slate-300 dark:border-gray-600 dark:bg-gray-900 text-slate-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 py-2.5 @error('acceptance_type_id') border-rose-500 ring-1 ring-rose-500 @enderror">
                                @foreach(\Packages\University\Models\AcceptanceType::all() as $at)
                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                @endforeach
                            </select>
                            @error('acceptance_type_id')
                                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. File Upload & Guidelines Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-gray-700">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-700 pb-4 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-sm">
                                <x-filament::icon icon="heroicon-o-document-arrow-up" class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="text-base font-extrabold text-slate-900 dark:text-white">
                                    الخطوة الثانية: رفع كشف إكسيل الطلاب
                                </h4>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    ملفات Excel (.xlsx, .xls) أو ملفات CSV
                                </span>
                            </div>
                        </div>
                        <span class="text-[11px] font-black px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300 border border-blue-200 dark:border-blue-900">
                            كشف الطلاب
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                        <!-- Dropzone (col-span-7) -->
                        <div class="lg:col-span-7">
                            <div class="relative border-2 border-dashed border-slate-300 dark:border-gray-600 rounded-2xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-400 transition-colors duration-200 bg-slate-50/60 dark:bg-gray-900/40 group">
                                <input
                                    type="file"
                                    wire:model="file"
                                    id="excel_file_input"
                                    accept=".xlsx,.xls,.csv"
                                    class="hidden"
                                />
                                <label for="excel_file_input" class="cursor-pointer block">
                                    <div class="w-16 h-16 mx-auto mb-3 bg-white dark:bg-gray-800 shadow-sm border border-slate-200 dark:border-gray-700 text-primary-600 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <x-filament::icon icon="heroicon-o-cloud-arrow-up" class="w-8 h-8 text-primary-600" />
                                    </div>
                                    <span class="text-sm font-extrabold text-primary-700 dark:text-primary-400 group-hover:underline block mb-1">
                                        انقر هنا لاختيار ملف الكشف من جهازك أو اسحبه إلى هنا
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">
                                        الصيغ المدعومة: XLSX, XLS, CSV (الحد الأقصى 10 ميغابايت)
                                    </span>
                                </label>

                                <div wire:loading wire:target="file" class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-700 text-xs font-bold">
                                    <span class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full"></span>
                                    جاري رفع الملف ومعالجته، يرجى الانتظار...
                                </div>

                                @if($file)
                                    <div class="mt-4 inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-950/80 text-emerald-900 dark:text-emerald-200 px-4 py-2 rounded-xl text-xs font-extrabold border border-emerald-300 dark:border-emerald-700 shadow-sm">
                                        <x-filament::icon icon="heroicon-s-check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                        <span>تم اختيار: <strong>{{ $file->getClientOriginalName() }}</strong> ({{ round($file->getSize() / 1024, 1) }} كيلوبايت)</span>
                                    </div>
                                @endif

                                @error('file')
                                    <div class="mt-3 text-xs font-extrabold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 p-2.5 rounded-lg border border-rose-200 dark:border-rose-900">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Note Banner -->
                            <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30 border border-emerald-200 dark:border-emerald-800/60 text-xs text-emerald-950 dark:text-emerald-200 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-filament::icon icon="heroicon-s-key" class="w-4 h-4 text-white" />
                                </div>
                                <div>
                                    <span class="font-black text-emerald-900 dark:text-emerald-300 block mb-0.5">توليد كلمة المرور آلياً:</span>
                                    <span class="leading-relaxed">
                                        سيتم تعيين كلمة مرور كل طالب في النظام تلقائياً لتكون <strong>رقمه الجامعي (University Number)</strong> المذكور في العمود الأول من الكشف، ولا حاجة لإدخال كلمة مرور يدوياً.
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Column Instructions (col-span-5) -->
                        <div class="lg:col-span-5 p-4 rounded-xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700 text-xs">
                            <div class="font-extrabold mb-3 flex items-center justify-between text-slate-900 dark:text-white text-xs">
                                <div class="flex items-center gap-1.5">
                                    <x-filament::icon icon="heroicon-s-shield-check" class="w-4 h-4 text-primary-600" />
                                    ترتيب أعمدة الكشف المعتمد (A إلى F):
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-primary-100 text-primary-800 dark:bg-primary-950 dark:text-primary-300 font-bold">
                                    ترتيب إلزامي
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[11px] mb-3">
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود A</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الرقم الجامعي (كلمة المرور)</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود B</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الاسم الاول</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود C</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الاسم الثاني</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود D</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الاسم الثالث</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود E</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الاسم الرابع</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700">
                                    <span class="font-black text-primary-700 dark:text-primary-400 block text-[10px]">العمود F</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100">الرقم الوطني</span>
                                </div>
                            </div>
                            <div class="text-[10px] text-slate-600 dark:text-slate-400 font-medium">
                                مثال: <code class="bg-slate-200 dark:bg-gray-800 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800 dark:text-slate-200">2858306 | احمد | يوسف | عوض | حماد | 129065086</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Full-Width Bottom Action Bar -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-slate-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs font-semibold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <x-filament::icon icon="heroicon-m-arrow-path" class="w-4 h-4 text-primary-600" />
                        <span>عند الضغط على الزر، سيتم التحقق من اكتمال البيانات الأكاديمية وفحص كشف الطلاب قبل أي حفظ.</span>
                    </div>

                    <button
                        type="button"
                        wire:click="parseAndPreview"
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 font-black py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm disabled:opacity-50 cursor-pointer"
                        style="background-color: #0284c7 !important; color: #ffffff !important; border: 1.5px solid #0369a1 !important;"
                    >
                        <x-filament::icon icon="heroicon-o-magnifying-glass" class="w-5 h-5 flex-shrink-0" style="color: #ffffff !important;" />
                        <span wire:loading.remove wire:target="parseAndPreview" style="color: #ffffff !important; font-weight: 800;">استخراج وفحص بيانات الطلاب</span>
                        <span wire:loading wire:target="parseAndPreview" style="color: #ffffff !important; font-weight: 800;">جاري المعالجة والتدقيق...</span>
                    </button>
                </div>

            </div>

        @elseif($step === 2)
            <!-- ========================================== -->
            <!-- STEP 2: Preview & Validation Table        -->
            <!-- ========================================== -->
            <div class="space-y-6">

                <!-- 1. Stats Overview Cards (عالية الوضوح والتباين) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Total -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-slate-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-extrabold text-slate-600 dark:text-slate-400 block mb-1">إجمالي المقروء بالملف</span>
                            <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $totalRows }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-slate-300 flex items-center justify-center">
                            <x-filament::icon icon="heroicon-o-document-text" class="w-6 h-6" />
                        </div>
                    </div>

                    <!-- Valid / Ready -->
                    <div class="bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl p-5 border border-emerald-200 dark:border-emerald-800 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-extrabold text-emerald-800 dark:text-emerald-300 block mb-1">جاهز للإضافة (سليم)</span>
                            <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $validCount }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 flex items-center justify-center">
                            <x-filament::icon icon="heroicon-o-check-circle" class="w-6 h-6" />
                        </div>
                    </div>

                    <!-- Duplicate -->
                    <div class="bg-amber-50 dark:bg-amber-950/40 rounded-2xl p-5 border border-amber-200 dark:border-amber-800 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-extrabold text-amber-900 dark:text-amber-300 block mb-1">مكرر بالنظام / الملف</span>
                            <span class="text-3xl font-black text-amber-600 dark:text-amber-400 tracking-tight">{{ $duplicateCount }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 flex items-center justify-center">
                            <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6" />
                        </div>
                    </div>

                    <!-- Invalid -->
                    <div class="bg-rose-50 dark:bg-rose-950/40 rounded-2xl p-5 border border-rose-200 dark:border-rose-800 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-extrabold text-rose-900 dark:text-rose-300 block mb-1">ينقصه بيانات أساسية</span>
                            <span class="text-3xl font-black text-rose-600 dark:text-rose-400 tracking-tight">{{ $invalidCount }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-900 text-rose-700 dark:text-rose-300 flex items-center justify-center">
                            <x-filament::icon icon="heroicon-o-x-circle" class="w-6 h-6" />
                        </div>
                    </div>
                </div>

                <!-- 2. Academic Specs Summary Bar -->
                @if($college_id || $academic_year_id || $batch_id || $department_id)
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800 border border-blue-200 dark:border-gray-700 rounded-2xl p-4 shadow-sm flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                <x-filament::icon icon="heroicon-s-academic-cap" class="w-5 h-5 text-white" />
                            </div>
                            <span class="text-xs font-black text-slate-800 dark:text-white">البيانات الأكاديمية المعتمدة للدفعة:</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            @if($college_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    الكلية: {{ \Packages\University\Models\College::find($college_id)?->name }}
                                </span>
                            @endif
                            @if($department_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    القسم: {{ \Packages\University\Models\Department::find($department_id)?->name }}
                                </span>
                            @endif
                            @if($academic_year_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    العام: {{ \Packages\University\Models\AcademicYear::find($academic_year_id)?->name }}
                                </span>
                            @endif
                            @if($batch_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    الدفعة: {{ \Packages\University\Models\Batch::find($batch_id)?->name }}
                                </span>
                            @endif
                            @if($level_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    المستوى: {{ \Packages\University\Models\Level::find($level_id)?->name }}
                                </span>
                            @endif
                            @if($acceptance_type_id)
                                <span class="px-3 py-1 rounded-lg bg-white dark:bg-gray-700 text-slate-800 dark:text-slate-200 text-xs font-extrabold border border-slate-200 dark:border-gray-600">
                                    نوع القبول: {{ \Packages\University\Models\AcceptanceType::find($acceptance_type_id)?->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- 3. Preview Table Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 md:p-5 border-b border-slate-200 dark:border-gray-700 bg-slate-50/50 dark:bg-gray-900/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <h4 class="font-black text-sm md:text-base text-slate-900 dark:text-white">
                                جدول معاينة وتدقيق الطلاب المستخرجين من الملف
                            </h4>
                            <span class="text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ count($previewRows) }} طالب
                            </span>
                        </div>
                        <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-3 py-1 rounded-lg border border-emerald-200 dark:border-emerald-800">
                            سيتم إضافة السجلات المؤشرة بـ (جاهز للإضافة) فقط
                        </span>
                    </div>

                    <div class="overflow-x-auto max-h-[520px]">
                        <table class="w-full text-right text-xs">
                            <thead class="bg-slate-100 dark:bg-gray-900 text-slate-800 dark:text-slate-200 font-black sticky top-0 z-10 border-b border-slate-200 dark:border-gray-700">
                                <tr>
                                    <th class="py-3.5 px-3 w-12 text-center">#</th>
                                    <th class="py-3.5 px-3">الرقم الجامعي</th>
                                    <th class="py-3.5 px-3">الاسم الاول</th>
                                    <th class="py-3.5 px-3">الاسم الثاني</th>
                                    <th class="py-3.5 px-3">الاسم الثالث</th>
                                    <th class="py-3.5 px-3">الاسم الرابع</th>
                                    <th class="py-3.5 px-3">الرقم الوطني</th>
                                    <th class="py-3.5 px-3 text-center">حالة السجل</th>
                                    <th class="py-3.5 px-3">الملاحظة والتدقيق</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-gray-700">
                                @forelse($previewRows as $item)
                                    <tr class="transition-colors {{ $item['status'] === 'ready' ? 'hover:bg-slate-50 dark:hover:bg-gray-700/40' : ($item['status'] === 'duplicate' ? 'bg-amber-50/60 dark:bg-amber-950/30' : 'bg-rose-50/60 dark:bg-rose-950/30') }}">
                                        <td class="py-3 px-3 text-center text-slate-600 dark:text-slate-400 font-mono font-bold">{{ $item['row_num'] }}</td>
                                        <td class="py-3 px-3 font-mono font-black text-blue-900 dark:text-blue-300 text-xs">{{ $item['university_no'] ?: '-' }}</td>
                                        <td class="py-3 px-3 font-black text-slate-900 dark:text-white">{{ $item['first_name'] ?: '-' }}</td>
                                        <td class="py-3 px-3 font-semibold text-slate-800 dark:text-slate-200">{{ $item['second_name'] ?: '-' }}</td>
                                        <td class="py-3 px-3 font-semibold text-slate-800 dark:text-slate-200">{{ $item['third_name'] ?: '-' }}</td>
                                        <td class="py-3 px-3 font-semibold text-slate-800 dark:text-slate-200">{{ $item['fourth_name'] ?: '-' }}</td>
                                        <td class="py-3 px-3 font-mono font-extrabold text-slate-800 dark:text-slate-200">{{ $item['national_id'] ?: '-' }}</td>
                                        <td class="py-3 px-3 text-center">
                                            @if($item['status'] === 'ready')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-sm"
                                                      style="background-color: #dcfce7 !important; color: #047857 !important; border-color: #86efac !important;">
                                                    <span class="w-2 h-2 rounded-full" style="background-color: #059669 !important;"></span>
                                                    جاهز للإضافة
                                                </span>
                                            @elseif($item['status'] === 'duplicate')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-sm"
                                                      style="background-color: #fef3c7 !important; color: #b45309 !important; border-color: #fcd34d !important;">
                                                    <span class="w-2 h-2 rounded-full" style="background-color: #d97706 !important;"></span>
                                                    مكرر
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-sm"
                                                      style="background-color: #ffe4e6 !important; color: #be123c !important; border-color: #fda4af !important;">
                                                    <span class="w-2 h-2 rounded-full" style="background-color: #e11d48 !important;"></span>
                                                    غير صالح
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-xs {{ $item['status'] === 'ready' ? 'text-slate-600 dark:text-slate-400 font-medium' : ($item['status'] === 'duplicate' ? 'text-amber-900 dark:text-amber-200 font-extrabold' : 'text-rose-900 dark:text-rose-200 font-extrabold') }}">
                                            {{ $item['message'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="p-8 text-center text-slate-500 font-bold">
                                            لا توجد بيانات مستخرجة
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. Bottom Action Bar -->
                    <div class="p-4 md:p-5 bg-slate-50 dark:bg-gray-900 border-t border-slate-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button
                            type="button"
                            wire:click="resetImport"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 font-black py-3 px-6 rounded-xl text-xs md:text-sm transition-all duration-200 cursor-pointer shadow-sm hover:shadow"
                            style="background-color: #f1f5f9 !important; color: #0f172a !important; border: 1.5px solid #cbd5e1 !important;"
                        >
                            &larr; إلغاء واختيار ملف كشف آخر
                        </button>

                        <button
                            type="button"
                            wire:click="executeImport"
                            wire:loading.attr="disabled"
                            @disabled($validCount === 0)
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 font-black py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg text-sm transition-all duration-200 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                            style="{{ $validCount > 0 ? 'background-color: #34d399 !important; color: #000000 !important; border: 1.5px solid #059669 !important;' : 'background-color: #e2e8f0 !important; color: #64748b !important; border: 1px solid #cbd5e1 !important;' }}"
                        >
                            <x-filament::icon icon="heroicon-s-check-circle" class="w-5 h-5 flex-shrink-0" style="color: {{ $validCount > 0 ? '#000000' : '#64748b' }} !important;" />
                            <span wire:loading.remove wire:target="executeImport" style="color: {{ $validCount > 0 ? '#000000' : '#64748b' }} !important; font-weight: 900;">
                                تأكيد وإضافة الطلاب الصالحين ({{ $validCount }})
                            </span>
                            <span wire:loading wire:target="executeImport" style="color: #000000 !important; font-weight: 900;">
                                جاري حفظ وإضافة الطلاب بالنظام...
                            </span>
                        </button>
                    </div>
                </div>

            </div>

        @elseif($step === 3)
            <!-- ========================================== -->
            <!-- STEP 3: Completed / Success Screen        -->
            <!-- ========================================== -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-200 dark:border-gray-700 p-8 md:p-12 text-center max-w-2xl mx-auto space-y-6">
                
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto shadow-inner ring-8 ring-emerald-50 dark:ring-emerald-950/40" style="background-color: #d1fae5 !important; color: #059669 !important;">
                    <x-filament::icon icon="heroicon-o-check-badge" class="w-12 h-12" style="color: #059669 !important;" />
                </div>

                <div class="space-y-2">
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white">
                        تم استيراد وإضافة بيانات الطلاب بنجاح!
                    </h3>
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 max-w-lg mx-auto leading-relaxed">
                        تم استخراج بيانات الطلاب من الكشف وحفظهم في النظام واعتماد <strong>الرقم الجامعي</strong> ككلمة مرور افتراضية لكل طالب، مع تجهيز السجلات الأكاديمية والمقابلات والكشوفات الطبية تلقائياً.
                    </p>
                </div>

                <!-- Stats Summary -->
                <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100 dark:border-gray-700 text-right">
                    <div class="p-5 rounded-2xl border" style="background-color: #ecfdf5 !important; border-color: #a7f3d0 !important;">
                        <span class="text-xs font-extrabold block mb-1" style="color: #065f46 !important;">الطلاب المضافون بنجاح</span>
                        <span class="text-3xl font-black block" style="color: #059669 !important;">{{ $importedCount }} طالب</span>
                    </div>

                    <div class="p-5 rounded-2xl border" style="background-color: #f8fafc !important; border-color: #e2e8f0 !important;">
                        <span class="text-xs font-extrabold block mb-1" style="color: #475569 !important;">المستبعدون (مكرر أو ناقص)</span>
                        <span class="text-3xl font-black block" style="color: #1e293b !important;">{{ $skippedCount }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
                    <a
                        href="{{ route('filament.admin.resources.university.students.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 font-black py-3 px-6 rounded-xl shadow-md hover:shadow-lg text-sm transition-all duration-200 cursor-pointer"
                        style="background-color: #0284c7 !important; color: #ffffff !important; border: 1.5px solid #0369a1 !important;"
                    >
                        <x-filament::icon icon="heroicon-o-users" class="w-5 h-5 flex-shrink-0" style="color: #ffffff !important;" />
                        <span style="color: #ffffff !important; font-weight: 800;">الانتقال لكشف الطلاب</span>
                    </a>

                    <a
                        href="{{ route('filament.admin.resources.university.student-interviews.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 font-black py-3 px-6 rounded-xl shadow-md hover:shadow-lg text-sm transition-all duration-200 cursor-pointer"
                        style="background-color: #4f46e5 !important; color: #ffffff !important; border: 1.5px solid #4338ca !important;"
                    >
                        <x-filament::icon icon="heroicon-o-clipboard-document-check" class="w-5 h-5 flex-shrink-0" style="color: #ffffff !important;" />
                        <span style="color: #ffffff !important; font-weight: 800;">كشف المقابلات الأكاديمية</span>
                    </a>

                    <button
                        type="button"
                        wire:click="resetImport"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 font-black py-3 px-6 rounded-xl shadow-sm hover:shadow text-sm transition-all duration-200 cursor-pointer"
                        style="background-color: #f1f5f9 !important; color: #0f172a !important; border: 1.5px solid #cbd5e1 !important;"
                    >
                        <x-filament::icon icon="heroicon-o-arrow-path" class="w-5 h-5 flex-shrink-0" style="color: #0f172a !important;" />
                        <span style="color: #0f172a !important; font-weight: 800;">استيراد كشف آخر</span>
                    </button>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
