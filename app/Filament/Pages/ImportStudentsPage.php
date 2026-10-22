<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\Batch;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Student;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportStudentsPage extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;
    protected string $view = 'filament.pages.import-students-page';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'students-import';

    public $file;
    public $college_id;
    public $academic_year_id;
    public $batch_id;
    public $department_id;
    public $level_id = 1;
    public $acceptance_type_id = 1;

    public int $step = 1; // 1: Upload & Academic Settings, 2: Preview & Validation, 3: Completed
    public array $previewRows = [];
    public int $totalRows = 0;
    public int $validCount = 0;
    public int $duplicateCount = 0;
    public int $invalidCount = 0;

    public int $importedCount = 0;
    public int $skippedCount = 0;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.import_students');
    }

    public function getHeading(): string
    {
        return __('backend.import_students_excel');
    }

    public function getTitle(): string|Htmlable
    {
        return __('backend.import_students_excel');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('import_students_from_excal') ?? false;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('import_students_from_excal'), 403);

        $this->academic_year_id =
            AcademicYear::query()->where('is_active', true)->value('id') ??
            AcademicYear::query()->latest('id')->value('id');
        $this->level_id = Level::query()->orderBy('sort_order')->value('id') ?? 1;
        $this->acceptance_type_id = AcceptanceType::query()->value('id') ?? 1;
    }

    public function updatedCollegeId($value): void
    {
        $this->department_id = null;
        $this->batch_id = null;
    }

    /**
     * Extract and parse Excel file into preview rows
     */
    public function parseAndPreview()
    {
        $this->validate(
            [
                'college_id' => 'required',
                'department_id' => 'required',
                'academic_year_id' => 'required',
                'batch_id' => 'required',
                'level_id' => 'required',
                'acceptance_type_id' => 'required',
                'file' => 'required',
            ],
            [
                'college_id.required' => 'اختيار الكلية إجباري قبل استخراج وفحص الكشف.',
                'department_id.required' => 'اختيار القسم الأكاديمي إجباري قبل استخراج وفحص الكشف.',
                'academic_year_id.required' => 'اختيار العام الأكاديمي إجباري.',
                'batch_id.required' => 'اختيار الدفعة الدراسية إجباري.',
                'level_id.required' => 'اختيار المستوى الدراسي إجباري.',
                'acceptance_type_id.required' => 'اختيار نوع القبول إجباري.',
                'file.required' => 'يرجى اختيار ملف الإكسيل للرفع.',
            ],
        );

        $extension = strtolower(pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION));
        if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
            $this->addError('file', 'يجب أن يكون الملف بصيغة Excel (xlsx, xls) أو CSV.');
            return;
        }

        try {
            $filePath = null;
            if (method_exists($this->file, 'getRealPath') && $this->file->getRealPath()) {
                $filePath = $this->file->getRealPath();
            } elseif (method_exists($this->file, 'path') && $this->file->path()) {
                $filePath = $this->file->path();
            }

            if (!$filePath || !file_exists($filePath)) {
                $fallback = storage_path('app/livewire-tmp/' . $this->file->getFilename());
                if (file_exists($fallback)) {
                    $filePath = $fallback;
                }
            }

            if (!$filePath || !file_exists($filePath)) {
                throw new \Exception('تعذر العثور على الملف المرفوع في المجلد المؤقت، يرجى إعادة اختيار الملف.');
            }

            if ($extension === 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                $reader->setInputEncoding('UTF-8');
                $firstLine = file_get_contents($filePath, false, null, 0, 500);
                if (str_contains($firstLine, ';')) {
                    $reader->setDelimiter(';');
                } elseif (str_contains($firstLine, "\t")) {
                    $reader->setDelimiter("\t");
                } else {
                    $reader->setDelimiter(',');
                }
                $spreadsheet = $reader->load($filePath);
            } else {
                $spreadsheet = IOFactory::load($filePath);
            }

            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);

            if (empty($rows)) {
                Notification::make()
                    ->title('الملف فارغ')
                    ->body('الملف المرفوع لا يحتوي على بيانات للاستيراد.')
                    ->warning()
                    ->send();
                return;
            }

            // Detect header mapping
            $headerRowIndex = 1;
            $headerMap = $this->detectHeaderColumns($rows[1] ?? []);

            // If row 1 did not have enough headers, check row 2
            if ($headerMap['confidence'] < 2 && isset($rows[2])) {
                $altMap = $this->detectHeaderColumns($rows[2]);
                if ($altMap['confidence'] > $headerMap['confidence']) {
                    $headerRowIndex = 2;
                    $headerMap = $altMap;
                }
            }

            // If no headers matched at all, default to row 1 being data
            if ($headerMap['confidence'] === 0) {
                $headerRowIndex = 0;
            }

            $existingUnivNos = Student::whereNotNull('university_no')
                ->pluck('university_no')
                ->map(fn($v) => trim((string) $v))
                ->flip()
                ->toArray();
            $existingNids = Student::whereNotNull('national_id_number')
                ->pluck('national_id_number')
                ->map(fn($v) => trim((string) $v))
                ->flip()
                ->toArray();

            $parsedData = [];
            $valid = 0;
            $duplicates = 0;
            $invalid = 0;

            $seenInFileUniv = [];
            $seenInFileNid = [];

            $cleanCode = function ($val) {
                if ($val === null) {
                    return '';
                }
                $str = trim((string) $val);
                if (empty($str)) {
                    return '';
                }
                if (preg_match('/^[0-9]+(\.[0-9]+)?e\+[0-9]+$/i', $str)) {
                    $str = sprintf('%.0f', (float) $str);
                } elseif (str_ends_with($str, '.0')) {
                    $str = substr($str, 0, -2);
                }
                return preg_replace('/[^\p{L}\p{N}_\-\/]/u', '', $str);
            };

            foreach ($rows as $rIndex => $row) {
                if ($rIndex <= $headerRowIndex) {
                    continue;
                }

                $univNo = $cleanCode($row[$headerMap['univ_col']] ?? '');
                $first = trim((string) ($row[$headerMap['first_col']] ?? ''));
                $second = trim((string) ($row[$headerMap['second_col']] ?? ''));
                $third = trim((string) ($row[$headerMap['third_col']] ?? ''));
                $fourth = trim((string) ($row[$headerMap['fourth_col']] ?? ''));
                $nid = $cleanCode($row[$headerMap['nid_col']] ?? '');

                // Handle single full name fallback if 4-parts were not separate
                if (
                    empty($first) &&
                    empty($second) &&
                    !empty($headerMap['fullname_col']) &&
                    !empty($row[$headerMap['fullname_col']])
                ) {
                    $parts = preg_split('/\s+/', trim((string) $row[$headerMap['fullname_col']]));
                    $first = $parts[0] ?? '';
                    $second = $parts[1] ?? '';
                    $third = $parts[2] ?? '';
                    $fourth = implode(' ', array_slice($parts, 3)) ?: $parts[3] ?? '';
                }

                // Skip completely empty rows
                if (empty($univNo) && empty($first) && empty($nid)) {
                    continue;
                }

                $status = 'ready';
                $statusMessage = 'جاهز للاستيراد';

                if (empty($univNo) || empty($first)) {
                    $status = 'invalid';
                    $statusMessage = 'الرقم الجامعي أو الاسم الأول مفقود';
                    $invalid++;
                } elseif (isset($existingUnivNos[$univNo])) {
                    $status = 'duplicate';
                    $statusMessage = 'الرقم الجامعي مسجل مسبقاً بالنظام';
                    $duplicates++;
                } elseif (!empty($nid) && isset($existingNids[$nid])) {
                    $status = 'duplicate';
                    $statusMessage = 'الرقم الوطني مسجل مسبقاً بالنظام';
                    $duplicates++;
                } elseif (isset($seenInFileUniv[$univNo])) {
                    $status = 'duplicate';
                    $statusMessage = 'الرقم الجامعي مكرر داخل نفس الملف';
                    $duplicates++;
                } else {
                    $valid++;
                    $seenInFileUniv[$univNo] = true;
                    if (!empty($nid)) {
                        $seenInFileNid[$nid] = true;
                    }
                }

                $fullName = trim("{$first} {$second} {$third} {$fourth}");

                $parsedData[] = [
                    'row_num' => $rIndex,
                    'university_no' => $univNo,
                    'first_name' => $first,
                    'second_name' => $second,
                    'third_name' => $third,
                    'fourth_name' => $fourth,
                    'full_name' => $fullName,
                    'national_id' => $nid,
                    'status' => $status,
                    'message' => $statusMessage,
                ];
            }

            $this->previewRows = $parsedData;
            $this->totalRows = count($parsedData);
            $this->validCount = $valid;
            $this->duplicateCount = $duplicates;
            $this->invalidCount = $invalid;
            $this->step = 2;

            Notification::make()
                ->title('تم استخراج البيانات بنجاح')
                ->body("تم العثور على {$this->totalRows} طالب ({$this->validCount} جاهز للإضافة).")
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()->title('خطأ أثناء قراءة ملف الإكسيل')->body($e->getMessage())->danger()->send();
        }
    }

    /**
     * Smart Header mapping with flexible synonyms
     */
    protected function detectHeaderColumns(array $headerRow): array
    {
        $map = [
            'univ_col' => 'A',
            'first_col' => 'B',
            'second_col' => 'C',
            'third_col' => 'D',
            'fourth_col' => 'E',
            'nid_col' => 'F',
            'fullname_col' => null,
            'confidence' => 0,
        ];

        foreach ($headerRow as $colLetter => $val) {
            $text = mb_strtolower(trim((string) $val));
            if (empty($text)) {
                continue;
            }

            $normalized = str_replace(['أ', 'إ', 'آ'], 'ا', $text);
            $normalized = str_replace(['ة'], 'ه', $normalized);

            // 1. National ID (الرقم الوطني)
            if (
                str_contains($normalized, 'وطن') ||
                str_contains($normalized, 'هوي') ||
                str_contains($normalized, 'national') ||
                str_contains($normalized, 'nid')
            ) {
                $map['nid_col'] = $colLetter;
                $map['confidence']++;
            }
            // 2. University Number (الرقم الجامعي / قيد الطالب)
            elseif (
                str_contains($normalized, 'جامع') ||
                str_contains($normalized, 'قيد') ||
                str_contains($normalized, 'univ') ||
                str_contains($normalized, 'student_no') ||
                str_contains($normalized, 'اكاديم')
            ) {
                $map['univ_col'] = $colLetter;
                $map['confidence']++;
            }
            // 3. Fourth Name (الاسم الرابع / اللقب / العائلة) - Checked before second to avoid false match on 'اب'
            elseif (
                str_contains($normalized, 'رابع') ||
                str_contains($normalized, 'لقب') ||
                str_contains($normalized, 'عائل') ||
                str_contains($normalized, 'fourth') ||
                str_contains($normalized, 'surname') ||
                str_contains($normalized, 'last')
            ) {
                $map['fourth_col'] = $colLetter;
                $map['confidence']++;
            }
            // 4. Third Name (الاسم الثالث / الجد)
            elseif (
                str_contains($normalized, 'ثالث') ||
                str_contains($normalized, 'جد') ||
                str_contains($normalized, 'third') ||
                str_contains($normalized, 'grand')
            ) {
                $map['third_col'] = $colLetter;
                $map['confidence']++;
            }
            // 5. Second Name (الاسم الثاني / اسم الأب / الوالد)
            elseif (
                str_contains($normalized, 'ثاني') ||
                str_contains($normalized, 'second') ||
                preg_match('/(^|\s)(ال)?(اب|والد)($|\s)/u', $normalized)
            ) {
                $map['second_col'] = $colLetter;
                $map['confidence']++;
            }
            // 6. First Name (الاسم الاول)
            elseif (str_contains($normalized, 'اول') || str_contains($normalized, 'first')) {
                $map['first_col'] = $colLetter;
                $map['confidence']++;
            }
            // 7. Full Name fallback (الاسم الكامل)
            elseif (
                str_contains($normalized, 'اسم') &&
                !str_contains($normalized, 'ثان') &&
                !str_contains($normalized, 'ثالث') &&
                !str_contains($normalized, 'رابع')
            ) {
                $map['fullname_col'] = $colLetter;
            }
        }

        return $map;
    }

    /**
     * Execute the actual import and database creation
     */
    public function executeImport()
    {
        $readyRows = array_filter($this->previewRows, fn($r) => $r['status'] === 'ready');

        if (empty($readyRows)) {
            Notification::make()
                ->title('لا توجد سجلات صالحة')
                ->body('جميع السجلات الموجودة في الكشف مكررة أو ينقصها بيانات أساسية.')
                ->warning()
                ->send();
            return;
        }

        DB::beginTransaction();
        try {
            $imported = 0;
            $skipped = 0;

            foreach ($readyRows as $item) {
                // Double check uniqueness
                if (Student::where('university_no', $item['university_no'])->exists()) {
                    $skipped++;
                    continue;
                }

                $rawUnivNo = trim((string) $item['university_no']);

                $student = Student::create([
                    'university_no' => $rawUnivNo,
                    'first_name' => $item['first_name'],
                    'second_name' => $item['second_name'],
                    'third_name' => $item['third_name'],
                    'fourth_name' => $item['fourth_name'],
                    'full_name' => $item['full_name'],
                    'national_id_number' => $item['national_id'] ?: null,
                    'password' => Hash::make($rawUnivNo), // كلمة مرور الطالب هي رقمه الجامعي تلقائياً
                    'is_active' => true,
                ]);

                // Create Academic Record with mandatory academic data
                $student->academicRecord()->create([
                    'college_id' => $this->college_id,
                    'academic_year_id' => $this->academic_year_id,
                    'batch_id' => $this->batch_id,
                    'department_id' => $this->department_id,
                    'level_id' => $this->level_id,
                    'acceptance_type_id' => $this->acceptance_type_id,
                    'academic_status_id' => 1,
                ]);

                // Create Medical Checkup
                $student->medicalCheckups()->create([
                    'ref_number' => 'MD-' . $student->id . '-' . $rawUnivNo,
                    'college_id' => $this->college_id,
                    'academic_year_id' => $this->academic_year_id,
                    'status' => 'pending',
                ]);

                // Create Student Interview Record in pending status
                $student->interviews()->create([
                    'ref_number' => 'INT-' . $student->id . '-' . $rawUnivNo,
                    'college_id' => $this->college_id,
                    'academic_year_id' => $this->academic_year_id,
                    'status' => StudentInterviewStatusEnum::Pending->value,
                    'interview_date' => now()->toDateString(),
                ]);

                $imported++;
            }

            DB::commit();

            $this->importedCount = $imported;
            $this->skippedCount = $skipped + $this->duplicateCount + $this->invalidCount;
            $this->step = 3;

            Notification::make()
                ->title('تم إتمام عملية الاستيراد بنجاح')
                ->body("تم حفظ وإضافة {$imported} طالب إلى النظام بنجاح وتجهيز سجلاتهم.")
                ->success()
                ->send();
        } catch (\Throwable $e) {
            DB::rollBack();
            Notification::make()->title('حدث خطأ أثناء حفظ البيانات')->body($e->getMessage())->danger()->send();
        }
    }

    /**
     * Reset and start a new import
     */
    public function resetImport()
    {
        $this->file = null;
        $this->previewRows = [];
        $this->totalRows = 0;
        $this->validCount = 0;
        $this->duplicateCount = 0;
        $this->invalidCount = 0;
        $this->importedCount = 0;
        $this->skippedCount = 0;
        $this->step = 1;
    }
}
