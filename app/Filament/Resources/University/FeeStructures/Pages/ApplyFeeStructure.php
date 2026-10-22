<?php

namespace App\Filament\Resources\University\FeeStructures\Pages;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Packages\Enum\PaymentStatusEnum;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Semester;
use Packages\University\Models\Student;
use Packages\University\Models\StudentCharge;

class ApplyFeeStructure extends Page implements HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = FeeStructureResource::class;

    protected string $view = 'filament.resources.university.fee-structures.pages.apply-fee-structure';

    public ?array $data = [];

    public function getHeading(): string|null
    {
        return __('backend.apply_fee_structure');
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill([
            'academic_year_id' => $this->record->academic_year_id,
            'college_id' => $this->record?->college_id,
            'department_id' => $this->record?->department_id,
            'level_id' => $this->record?->level_id,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->compact()
                    ->columns(4)
                    ->schema([
                        Select::make('academic_year_id')
                            ->label(__('backend.academic_year'))
                            ->options(
                                AcademicYear::query()
                                    ->orderBy('name')
                                    ->where('id', $this->record->academic_year_id)
                                    ->pluck('name', 'id'),
                            )
                            ->default(fn() => $this->record?->academic_year_id)
                            ->required(),
                        Select::make('college_id')
                            ->label(__('backend.college'))
                            ->hidden(fn() => $this->record->is_medical_checkup_structure == true)
                            ->options(College::where('id', $this->record->college_id)->pluck('name', 'id'))
                            ->default(fn() => $this->record?->college->id)
                            ->required(),
                        Select::make('department_id')
                            ->label(__('backend.department'))
                            ->hidden(fn() => $this->record->is_medical_checkup_structure == true)
                            ->options(Department::where('id', $this->record->department_id)->pluck('name', 'id'))
                            ->default(fn() => $this->record?->department->id)
                            ->required(),
                        Select::make('level_id')
                            ->label(__('backend.level'))
                            ->hidden(fn() => $this->record->is_medical_checkup_structure == true)
                            ->options(Level::where('id', $this->record->level_id)->pluck('name', 'id'))
                            ->default(fn() => $this->record?->level->id)
                            ->required(),
                    ]),
                Section::make(__('backend.reg_info'))
                    ->compact()
                    ->columns(1)
                    ->schema([
                        //
                        // ::TODO:: Get Actual Count
                        TextEntry::make('std_count')
                            ->label(__('backend.students'))
                            ->state(
                                Student::query()
                                    ->whereHas(
                                        'academicRecord',
                                        fn($q) => $q
                                            ->where('college_id', $this->record->college_id)
                                            ->where('academic_year_id', $this->record->academic_year_id),
                                    )
                                    ->whereDoesntHave('charges')
                                    ->count(),
                            ),
                        RepeatableEntry::make('students') // أو تغييرها إلى الاسم المناسب للبيانات المسترجعة
                            ->getStateUsing(function () {
                                return Student::query()
                                    ->whereHas(
                                        'academicRecord',
                                        fn($q) => $q
                                            ->where('college_id', $this->record->college_id)
                                            ->where('academic_year_id', $this->record->academic_year_id),
                                    )
                                    ->whereDoesntHave('charges')
                                    ->get();
                            })
                            ->label(__('backend.students'))
                            ->schema([
                                // استخدام TextEntry فقط داخل الـ schema (بدون table() و TableColumn)
                                TextEntry::make('name')->label(__('backend.name')),
                                TextEntry::make('university_no')->label(__('backend.university_no')),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function applyAction(): Action
    {
        return Action::make('apply')
            ->label(__('backend.apply_fee_structure'))
            ->color('primary')
            ->requiresConfirmation()
            ->action(fn() => $this->submit());
    }

    public function submit(): void
    {
        $state = $this->form->getState();

        $feeStructure = $this->record;

        if (!$feeStructure->is_approved) {
            Notification::make()->title(__('backend.fee_structure_not_approved'))->danger()->send();

            return;
        }

        $items = $feeStructure->items;

        if ($items->isEmpty()) {
            Notification::make()->title(__('backend.fee_structure_has_no_items'))->danger()->send();

            return;
        }

        $created = 0;
        $skipped = 0;

        DB::transaction(function () use ($state, $feeStructure, $items, &$created, &$skipped): void {
            Student::query()
                ->whereHas(
                    'academicRecord',
                    fn($q) => $q
                        ->where('college_id', $state['college_id'])
                        ->where('academic_year_id', $state['academic_year_id']),
                )
                ->whereDoesntHave('charges')
                ->orderBy('id')
                ->chunkById(200, function ($students) use ($state, $feeStructure, $items, &$created, &$skipped): void {
                    foreach ($students as $student) {
                        foreach ($items as $item) {
                            $exists = DB::table('student_charges')
                                ->where('student_id', $student->id)
                                ->where('fee_structure_id', $feeStructure->id)
                                ->where('fee_structure_item_id', $item->id)
                                ->where('academic_year_id', $state['academic_year_id'])
                                ->exists();

                            if ($exists) {
                                $skipped++;

                                continue;
                            }

                            StudentCharge::create([
                                'currency_id' => $feeStructure->currency_id,
                                'student_id' => $student->id,
                                'fee_structure_id' => $feeStructure->id,
                                'fee_type_id' => $item->feeType->id,
                                'fee_structure_item_id' => $item->id,
                                'academic_year_id' => $state['academic_year_id'],
                                'net_amount' => $item->amount,
                                'status' => PaymentStatusEnum::UNPAID->value,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            $created++;
                        }
                    }
                });
        });

        Notification::make()
            ->title(__('backend.fee_structure_applied_successfully'))
            ->body("Created: {$created} charges. Skipped: {$skipped} existing charges.")
            ->success()
            ->send();
    }
}
