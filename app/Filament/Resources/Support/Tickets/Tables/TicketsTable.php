<?php

namespace App\Filament\Resources\Support\Tickets\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Packages\Enum\PriorityEnum;
use Packages\Enum\Profile\GenderEnum;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\Ticket;
use Packages\Support\Models\TicketCategory;
use Packages\Support\Models\TicketReply;
use Packages\University\Enums\IdentityTypeEnum;
use Packages\University\Models\Student;
use Packages\University\Models\StudentIdentity;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn($record) => route('filament.admin.resources.support.tickets.edit', ['record' => $record]))
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('رقم التذكرة')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('backend.title'))
                    ->weight('bold')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('submitter')
                    ->label('مقدم الطلب')
                    ->state(fn($record) => $record->submitter_name)
                    ->description(fn($record) => $record->is_from_student ? ('طالب - الرقم الجامعي: ' . ($record->student?->university_no ?? '—')) : null)
                    ->badge(fn($record) => $record->is_from_student)
                    ->color(fn($record) => $record->is_from_student ? 'info' : 'gray')
                    ->icon(fn($record) => $record->is_from_student ? Heroicon::OutlinedAcademicCap : Heroicon::OutlinedUser)
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHasMorph('ticketable', [Student::class, User::class], function ($q, $type) use ($search) {
                            if ($type === Student::class) {
                                $q->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('second_name', 'like', "%{$search}%")
                                    ->orWhere('university_no', 'like', "%{$search}%")
                                    ->orWhere('national_id_number', 'like', "%{$search}%");
                            } else {
                                $q->where('name', 'like', "%{$search}%");
                            }
                        });
                    }),

                TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('priority')
                    ->badge()
                    ->color(fn($record) => $record->priority?->getColor() ?? 'gray')
                    ->state(fn($record) => $record->priority?->label() ?? 'متوسطة')
                    ->label(__('backend.priority')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($record) => match ($record->status?->value) {
                        'open' => 'info',
                        'in_progress' => 'warning',
                        'closed' => 'success',
                        default => 'gray',
                    })
                    ->state(fn($record) => $record->status?->label() ?? 'مفتوحة')
                    ->label(__('backend.status')),

                TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('الردود')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة التذكرة')
                    ->options(TicketStatusEnum::options()),

                SelectFilter::make('priority')
                    ->label(__('backend.priority'))
                    ->options(PriorityEnum::options()),

                SelectFilter::make('ticket_category_id')
                    ->label('التصنيف والقسم')
                    ->options(fn() => TicketCategory::where('is_enabled', true)->pluck('name', 'id')),
            ])
            ->filtersTriggerAction(fn(Action $action) => $action->button()->label(__('backend.filters')))
            ->recordActions([
                // 1. Action: Edit Student Data & Photo (تعديل بيانات وصورة الطالب)
                Action::make('edit_student_data')
                    ->label('تعديل بيانات وصورة الطالب')
                    ->icon(Heroicon::OutlinedUserCircle)
                    ->color('success')
                    ->visible(fn($record) => $record->is_from_student && $record->student !== null)
                    ->modalWidth('4xl')
                    ->modalHeading('تعديل بيانات الطالب والصورة والمستندات')
                    ->modalSubheading(fn($record) => 'الطالب: ' . ($record->student?->name ?? '') . ' (الرقم الجامعي: ' . ($record->student?->university_no ?? '') . ')')
                    ->fillForm(fn($record) => [
                        'first_name' => $record->student?->first_name,
                        'second_name' => $record->student?->second_name,
                        'third_name' => $record->student?->third_name,
                        'fourth_name' => $record->student?->fourth_name,
                        'full_name_en' => $record->student?->full_name_en,
                        'national_id_number' => $record->student?->national_id_number,
                        'phone' => $record->student?->phone ?? $record->student?->guardian_phone,
                        'address' => $record->student?->address,
                        'permanent_address' => $record->student?->permanent_address,
                        'gender' => $record->student?->gender?->value ?? $record->student?->gender,
                        'date_of_birth' => $record->student?->date_of_birth,
                        'guardian_name' => $record->student?->guardian_name,
                        'guardian_phone' => $record->student?->guardian_phone,
                        'profile_picture' => $record->student?->profile_picture,
                    ])
                    ->schema(function (?Ticket $record) {
                        $attachments = $record ? $record->getStudentAttachments() : [];

                        $attachmentComponents = [];
                        if (empty($attachments)) {
                            $attachmentComponents[] = Placeholder::make('no_attachments_notice')
                                ->hiddenLabel()
                                ->content(new HtmlString("
                                    <div class='p-4 rounded-xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-700 text-center space-y-1'>
                                        <span class='text-xs font-bold text-slate-600 dark:text-slate-400 block'>لم يرفق الطالب أي صورة أو مستند مع هذه التذكرة</span>
                                        <span class='text-[11px] text-slate-400 dark:text-slate-500 block'>يمكنك رفع صورة شخصية جديدة يدوياً أدناه أو تعديل البيانات الأساسية.</span>
                                    </div>
                                "));
                        } else {
                            foreach ($attachments as $i => $att) {
                                $url = $att['url'];
                                $displaySrc = $att['data_uri'] ?? $url;
                                $source = htmlspecialchars($att['source']);
                                $sender = htmlspecialchars($att['sender']);
                                $date = $att['created_at']->format('Y-m-d H:i');
                                $isImg = $att['is_image'];
                                $ext = strtoupper($att['extension']);

                                $previewHtml = "
                                    <div class='flex flex-col md:flex-row items-center gap-5 p-4 rounded-2xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-700 shadow-sm'>
                                        <div class='flex-shrink-0 bg-white dark:bg-gray-800 p-2.5 rounded-2xl border border-slate-200 dark:border-gray-700 shadow-sm flex items-center justify-center max-w-full'>
                                ";

                                if ($isImg) {
                                    $previewHtml .= "
                                            <a href='{$url}' target='_blank' title='اضغط للتكبير وعرض الصورة بالحجم الكامل' class='block'>
                                                <img src='{$displaySrc}' class='max-h-64 sm:max-h-72 w-auto max-w-full object-contain rounded-xl hover:scale-[1.02] transition-transform duration-200 cursor-pointer shadow-sm' />
                                            </a>
                                    ";
                                } else {
                                    $previewHtml .= "
                                            <div class='w-32 h-32 rounded-xl bg-slate-100 dark:bg-gray-800 flex flex-col items-center justify-center p-3 text-center border border-slate-300'>
                                                <span class='text-xs font-black text-slate-700 dark:text-slate-300'>ملف ({$ext})</span>
                                                <a href='{$url}' target='_blank' class='text-[11px] font-bold text-primary-600 underline mt-2'>معاينة / تحميل</a>
                                            </div>
                                    ";
                                }

                                $previewHtml .= "
                                        </div>
                                        <div class='space-y-2 text-center md:text-right flex-1'>
                                            <div class='flex flex-wrap items-center justify-center md:justify-start gap-2'>
                                                <span class='px-3 py-1 rounded-lg text-xs font-black bg-indigo-600 text-white shadow-sm'>مرفق #".($i+1)."</span>
                                                <span class='text-sm font-black text-slate-900 dark:text-white'>{$source}</span>
                                            </div>
                                            <div class='text-xs text-slate-500 dark:text-slate-400 space-y-1'>
                                                <div>مرسل من: <strong class='text-slate-700 dark:text-slate-200'>{$sender}</strong></div>
                                                <div>تاريخ الرفع: <strong class='text-slate-700 dark:text-slate-200'>{$date}</strong> • نوع الملف: <span class='uppercase font-mono font-bold text-slate-800 dark:text-slate-100'>{$ext}</span></div>
                                            </div>
                                            <div class='pt-2 flex flex-wrap items-center justify-center md:justify-start gap-2'>
                                                <a href='{$url}' target='_blank' class='inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-indigo-600 hover:text-indigo-800 shadow-sm transition-all'>
                                                    <span>عرض بالحجم الكامل في نافذة جديدة</span> ↗
                                                </a>
                                                <a href='{$url}' target='_blank' download class='inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-700 hover:text-slate-900 shadow-sm transition-all'>
                                                    <span>تحميل المرفق</span> 📥
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                ";

                                $attachmentComponents[] = Section::make("المرفق #" . ($i + 1) . ": {$source}")
                                    ->description("اختر من القائمة المنسدلة أدناه كيفية استخدام واعتماد هذا المرفق في ملف وسجل الطالب")
                                    ->collapsible()
                                    ->collapsed(false)
                                    ->schema([
                                        Placeholder::make("attachment_preview_{$i}")
                                            ->hiddenLabel()
                                            ->content(new HtmlString($previewHtml)),

                                        Select::make("attachment_action_{$i}")
                                            ->label('تحديد استخدام هذا المرفق في ملف الطالب:')
                                            ->options([
                                                'none' => '⚪ الاحتفاظ في التذكرة فقط (بدون استخدام في الملف)',
                                                'profile_picture' => '👤 اعتماد كصورة شخصية رسمية للطالب (تظهر بالبطاقة والشهادات)',
                                                'identity_proof' => '🪪 اعتماد كمستند إثبات شخصية (الرقم الوطني / الهوية الرسمية)',
                                                'sudanese_certificate' => '📜 اعتماد كمستند الشهادة السودانية (الثانوية العامة)',
                                                'passport' => '🛂 اعتماد كمستند جواز السفر',
                                                'birth_certificate' => '📄 اعتماد كمستند شهادة الميلاد',
                                                'other' => '📁 اعتماد كمستند / وثيقة أخرى',
                                            ])
                                            ->default('none')
                                            ->selectablePlaceholder(false)
                                            ->native(false)
                                            ->searchable()
                                            ->live(),

                                        Grid::make(2)
                                            ->visible(fn(Get $get) => in_array($get("attachment_action_{$i}"), [
                                                'identity_proof', 'sudanese_certificate', 'passport', 'birth_certificate', 'other'
                                            ]))
                                            ->schema([
                                                TextInput::make("attachment_number_{$i}")
                                                    ->label('رقم المستند / رقم الجلوس أو الوثيقة (اختياري)')
                                                    ->placeholder('مثال: 12345678')
                                                    ->default(fn() => $record?->student?->national_id_number),

                                                TextInput::make("attachment_notes_{$i}")
                                                    ->label('ملاحظات المستند (اختياري)')
                                                    ->placeholder('ملاحظات إضافية...')
                                                    ->default('معتمد من تذكرة الدعم ' . ($record?->ticket_number ?? '')),
                                            ]),
                                    ]);
                            }
                        }

                        $currentPhotoPreview = function (?Ticket $record) {
                            $student = $record?->student;
                            if (!$student) return '';

                            $avatarUrl = asset('static/student_profile_picture.jpg');
                            if (!empty($student->profile_picture)) {
                                if (Storage::disk('public')->exists($student->profile_picture)) {
                                    $ext = strtolower(pathinfo($student->profile_picture, PATHINFO_EXTENSION));
                                    $mime = match ($ext) {
                                        'png' => 'image/png',
                                        'gif' => 'image/gif',
                                        'webp' => 'image/webp',
                                        default => 'image/jpeg',
                                    };
                                    try {
                                        $content = Storage::disk('public')->get($student->profile_picture);
                                        if ($content && strlen($content) <= 8 * 1024 * 1024) {
                                            $avatarUrl = 'data:' . $mime . ';base64,' . base64_encode($content);
                                        } else {
                                            $avatarUrl = asset('storage/' . $student->profile_picture);
                                        }
                                    } catch (\Throwable $e) {
                                        $avatarUrl = asset('storage/' . $student->profile_picture);
                                    }
                                } else {
                                    $avatarUrl = asset('storage/' . $student->profile_picture);
                                }
                            }

                            $name = htmlspecialchars($student->name);
                            $uniNo = htmlspecialchars($student->university_no ?? '—');
                            $natId = htmlspecialchars($student->national_id_number ?? '—');
                            $docsCount = $student->identities()->count();

                            return new HtmlString("
                                <div class='flex flex-col sm:flex-row items-center gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-gray-900/60 border border-slate-200 dark:border-gray-700 mb-2'>
                                    <div class='relative flex-shrink-0'>
                                        <img src='{$avatarUrl}' alt='{$name}' class='w-20 h-20 rounded-2xl object-cover border-2 border-primary-500 shadow-md bg-white' />
                                        <span class='absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-md text-[9px] font-black bg-emerald-500 text-white shadow-sm'>معتمدة</span>
                                    </div>
                                    <div class='text-center sm:text-right space-y-1 flex-1'>
                                        <div class='flex flex-wrap items-center justify-center sm:justify-start gap-2'>
                                            <h4 class='text-sm font-black text-slate-900 dark:text-white'>{$name}</h4>
                                            <span class='text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300'>الرقم الجامعي: {$uniNo}</span>
                                        </div>
                                        <p class='text-xs text-slate-500 dark:text-slate-400'>
                                            الرقم الوطني: <strong class='text-slate-700 dark:text-slate-300'>{$natId}</strong>
                                            • الوثائق المسجلة: <strong class='text-slate-700 dark:text-slate-300'>{$docsCount} مستند</strong>
                                        </p>
                                        <p class='text-[11px] text-slate-400'>هذه هي الصورة المعتمدة حالياً في البطاقة الجامعية وسجل الطالب الأكاديمي.</p>
                                    </div>
                                </div>
                            ");
                        };

                        return [
                            Tabs::make()->schema([
                                Tab::make('البيانات الأساسية للطالب')
                                    ->icon(Heroicon::OutlinedIdentification)
                                    ->columns(4)
                                    ->schema([
                                        TextInput::make('first_name')->label(__('backend.first_name'))->required(),
                                        TextInput::make('second_name')->label(__('backend.second_name'))->required(),
                                        TextInput::make('third_name')->label(__('backend.third_name'))->required(),
                                        TextInput::make('fourth_name')->label(__('backend.fourth_name'))->required(),
                                        TextInput::make('full_name_en')->label('الاسم الكامل بالإنجليزية')->columnSpan(2),
                                        TextInput::make('national_id_number')->label('الرقم الوطني')->required()->columnSpan(2),
                                        Select::make('gender')->label('الجنس')->options(GenderEnum::getOptions())->columnSpan(2),
                                        DatePicker::make('date_of_birth')->label('تاريخ الميلاد')->columnSpan(2),
                                        TextInput::make('phone')->label('رقم الهاتف')->columnSpan(2),
                                        TextInput::make('address')->label('العنوان الحالي')->columnSpan(2),
                                        TextInput::make('guardian_name')->label('اسم ولي الأمر')->columnSpan(2),
                                        TextInput::make('guardian_phone')->label('هاتف ولي الأمر')->columnSpan(2),
                                    ]),

                                Tab::make('الصور والمستندات المرفقة')
                                    ->icon(Heroicon::OutlinedPhoto)
                                    ->schema([
                                        // 1. Current Photo preview
                                        Section::make('الصورة المعتمدة حالياً للطالب بالنظام')
                                            ->collapsible()
                                            ->collapsed(false)
                                            ->schema([
                                                Placeholder::make('current_student_photo_preview')
                                                    ->hiddenLabel()
                                                    ->content($currentPhotoPreview($record)),
                                            ]),

                                        // 2. Attached images & usage selector
                                        Section::make('الصور والمرفقات المستلمة من الطالب في التذكرة (' . count($attachments) . ')')
                                            ->description('يمكنك معاينة كل صورة مرفقة واختيار اعتمادها كصورة شخصية أو كمستند إثبات شخصية أو شهادة سودانية')
                                            ->collapsible()
                                            ->collapsed(false)
                                            ->schema($attachmentComponents),

                                        // 3. Manual upload option
                                        Section::make('رفع صورة شخصية جديدة يدوياً (اختياري)')
                                            ->collapsible()
                                            ->collapsed(true)
                                            ->schema([
                                                FileUpload::make('profile_picture')
                                                    ->label('اختر صورة شخصية من جهازك')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->disk('public')
                                                    ->directory(fn($record) => 'students/' . ($record->student?->university_no ?? 'general') . '/profile_pictures')
                                                    ->visibility('public')
                                                    ->maxSize(5120)
                                                    ->helperText('يمكنك رفع صورة شخصية جديدة للطالب مباشرة من جهازك في حال عدم إرفاقها بالتذكرة.'),
                                            ]),
                                    ]),
                            ])->columnSpanFull(),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        $student = $record->student;
                        if (!$student) {
                            return;
                        }

                        // 1. Update basic info
                        $student->update([
                            'first_name' => $data['first_name'] ?? $student->first_name,
                            'second_name' => $data['second_name'] ?? $student->second_name,
                            'third_name' => $data['third_name'] ?? $student->third_name,
                            'fourth_name' => $data['fourth_name'] ?? $student->fourth_name,
                            'full_name_en' => $data['full_name_en'] ?? $student->full_name_en,
                            'national_id_number' => $data['national_id_number'] ?? $student->national_id_number,
                            'phone' => $data['phone'] ?? $student->phone,
                            'address' => $data['address'] ?? $student->address,
                            'gender' => $data['gender'] ?? $student->gender,
                            'date_of_birth' => $data['date_of_birth'] ?? $student->date_of_birth,
                            'guardian_name' => $data['guardian_name'] ?? $student->guardian_name,
                            'guardian_phone' => $data['guardian_phone'] ?? $student->guardian_phone,
                        ]);

                        $messages = [];

                        // 2. Manual profile picture upload if provided
                        if (!empty($data['profile_picture'])) {
                            $student->update(['profile_picture' => $data['profile_picture']]);
                            $messages[] = 'تم تحديث الصورة الشخصية للطالب عبر الرفع المباشر';
                        }

                        // 3. Process attachments based on admin selection
                        $attachments = $record->getStudentAttachments();
                        foreach ($attachments as $i => $att) {
                            $action = $data["attachment_action_{$i}"] ?? 'none';
                            $path = $att['path'];
                            $docNumber = $data["attachment_number_{$i}"] ?? null;
                            $docNotes = $data["attachment_notes_{$i}"] ?? null;

                            if (!Storage::disk('public')->exists($path)) {
                                continue;
                            }

                            $ext = pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg';
                            $uniNo = $student->university_no ?? 'general';

                            if ($action === 'profile_picture') {
                                $targetDir = "students/{$uniNo}/profile_pictures";
                                $targetFilename = $targetDir . '/avatar_' . time() . '_' . uniqid() . '.' . $ext;
                                Storage::disk('public')->copy($path, $targetFilename);
                                $student->update(['profile_picture' => $targetFilename]);
                                $messages[] = 'تم اعتماد المرفق كصورة شخصية رسمية';
                            } elseif ($action === 'identity_proof') {
                                $targetDir = "students/{$uniNo}/identities";
                                $targetFilename = $targetDir . '/identity_national_' . time() . '_' . uniqid() . '.' . $ext;
                                Storage::disk('public')->copy($path, $targetFilename);
                                StudentIdentity::create([
                                    'student_id' => $student->id,
                                    'type' => IdentityTypeEnum::NationalId,
                                    'number' => $docNumber ?: $student->national_id_number,
                                    'attachment' => $targetFilename,
                                    'notes' => $docNotes ?: ('مستند إثبات شخصية معتمد من تذكرة الدعم ' . ($record->ticket_number ?? ('#' . $record->id))),
                                ]);
                                $messages[] = 'تمت إضافة المرفق كمستند إثبات شخصية (الرقم الوطني)';
                            } elseif ($action === 'sudanese_certificate') {
                                $targetDir = "students/{$uniNo}/identities";
                                $targetFilename = $targetDir . '/identity_cert_' . time() . '_' . uniqid() . '.' . $ext;
                                Storage::disk('public')->copy($path, $targetFilename);
                                StudentIdentity::create([
                                    'student_id' => $student->id,
                                    'type' => IdentityTypeEnum::SecondaryCertificate,
                                    'number' => $docNumber,
                                    'attachment' => $targetFilename,
                                    'notes' => $docNotes ?: ('مستند الشهادة السودانية معتمد من تذكرة الدعم ' . ($record->ticket_number ?? ('#' . $record->id))),
                                ]);
                                $messages[] = 'تمت إضافة المرفق كمستند الشهادة السودانية';
                            } elseif (in_array($action, ['passport', 'birth_certificate', 'other'])) {
                                $typeEnum = match ($action) {
                                    'passport' => IdentityTypeEnum::Passport,
                                    'birth_certificate' => IdentityTypeEnum::BirthCertificate,
                                    default => IdentityTypeEnum::Other,
                                };
                                $targetDir = "students/{$uniNo}/identities";
                                $targetFilename = $targetDir . '/doc_' . $action . '_' . time() . '_' . uniqid() . '.' . $ext;
                                Storage::disk('public')->copy($path, $targetFilename);
                                StudentIdentity::create([
                                    'student_id' => $student->id,
                                    'type' => $typeEnum,
                                    'number' => $docNumber,
                                    'attachment' => $targetFilename,
                                    'notes' => $docNotes ?: ('مستند (' . $typeEnum->getLabel() . ') معتمد من تذكرة الدعم ' . ($record->ticket_number ?? ('#' . $record->id))),
                                ]);
                                $messages[] = 'تمت إضافة المرفق كمستند (' . $typeEnum->getLabel() . ')';
                            }
                        }

                        $summary = count($messages) ? implode('، و', $messages) : 'تم تحديث البيانات الأساسية بنجاح';

                        Notification::make()
                            ->success()
                            ->title('تم حفظ وتحديث بيانات الطالب ومستنداته بنجاح')
                            ->body("الطالب: {$student->name} — {$summary}.")
                            ->send();
                    }),

                // 2. Action: Quick Reply to Student (الرد على الطالب)
                Action::make('quick_reply')
                    ->label('إرسال رد للطالب')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('primary')
                    ->modalWidth('2xl')
                    ->modalHeading(fn($record) => 'إرسال رد على التذكرة: ' . ($record->ticket_number ?? ''))
                    ->schema([
                        Textarea::make('reply')
                            ->label('نص الرد')
                            ->placeholder('اكتب نص الرد الموجه للطالب هنا...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('attachment')
                            ->label('إرفاق ملف أو مستند (اختياري)')
                            ->disk('public')
                            ->directory('tickets/replies')
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('تحديث حالة التذكرة')
                            ->options(TicketStatusEnum::options())
                            ->default(fn($record) => $record->status?->value ?? TicketStatusEnum::InProgress->value)
                            ->required(),

                        Toggle::make('is_internal_note')
                            ->label('ملاحظة داخلية خاصة بقسم الدعم (لا تظهر للطالب)')
                            ->default(false),
                    ])
                    ->action(function ($record, array $data) {
                        TicketReply::create([
                            'ticket_id' => $record->id,
                            'repliable_type' => User::class,
                            'repliable_id' => auth()->id(),
                            'reply' => $data['reply'],
                            'attachment' => $data['attachment'] ?? null,
                            'is_internal_note' => $data['is_internal_note'] ?? false,
                        ]);

                        if (!empty($data['status'])) {
                            $record->status = $data['status'];
                            if ($data['status'] === TicketStatusEnum::Closed->value) {
                                $record->closed_at = now();
                            }
                            $record->save();
                        }

                        Notification::make()
                            ->success()
                            ->title('تم إرسال الرد بنجاح')
                            ->body('تمت إضافة ردك إلى التذكرة وإشعار الطالب به.')
                            ->send();
                    }),

                // 3. Status Update
                Action::make('status_update')
                    ->modalWidth('md')
                    ->color('warning')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->label(__('backend.update_status'))
                    ->schema([
                        Select::make('status')
                            ->label(__('backend.status'))
                            ->options(function ($record) {
                                $options = TicketStatusEnum::options();
                                unset($options[$record->status?->value]);
                                return $options;
                            })
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->status = $data['status'];
                        if ($data['status'] === TicketStatusEnum::Closed->value) {
                            $record->closed_at = now();
                        }
                        $record->save();
                    }),

                EditAction::make()->iconButton(),

                ActionGroup::make([
                    DeleteAction::make()->disabled(fn($record) => !auth()->user()->can('support_ticket_management')),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
