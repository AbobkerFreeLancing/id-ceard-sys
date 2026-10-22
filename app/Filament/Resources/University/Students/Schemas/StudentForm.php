<?php

namespace App\Filament\Resources\University\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Packages\Enum\Profile\GenderEnum;
use Packages\University\Enums\GuardianRelationshipEnum;
use Packages\University\Models\AcademicStatus;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\Batch;
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Level;
use Packages\University\Models\Student;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Tabs::make()->schema([
                            Tab::make(ucfirst(__('backend.basic_info')))
                                ->icon(Heroicon::InformationCircle)
                                ->columns(2)
                                ->schema([
                                    FusedGroup::make()
                                        ->label(__('backend.full_name'))
                                        ->columns(4)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('first_name')
                                                ->placeholder(__('backend.first_name'))
                                                ->minLength(2)
                                                ->maxLength(40)
                                                ->required(),
                                            TextInput::make('second_name')
                                                ->placeholder(__('backend.second_name'))
                                                ->minLength(2)
                                                ->maxLength(40)
                                                ->required(),
                                            TextInput::make('third_name')
                                                ->placeholder(__('backend.third_name'))
                                                ->minLength(2)
                                                ->maxLength(40)
                                                ->required(),
                                            TextInput::make('fourth_name')
                                                ->placeholder(__('backend.third_name'))
                                                ->minLength(2)
                                                ->maxLength(40)
                                                ->required(),
                                        ]),
                                    // TextInput::make('full_name')
                                    //     ->label(__('backend.full_name'))
                                    //     ->minLength(10)
                                    //     ->maxLength(65)
                                    //     ->required()
                                    //     ->unique(ignoreRecord: true),
                                    TextInput::make('full_name_en')
                                        ->minLength(10)
                                        ->label(__('backend.full_name_en'))
                                        ->maxLength(65),
                                    TextInput::make('university_no')
                                        ->label(__('backend.university_no'))
                                        ->required()
                                        ->numeric()
                                        ->unique(ignoreRecord: true),
                                    TextInput::make('national_id_number')
                                        ->label(__('backend.national_id_number'))
                                        ->unique(ignoreRecord: true),
                                    TextInput::make('address')->label(__('backend.current_address'))->maxLength(80),
                                    TextInput::make('permanent_address')
                                        ->label(__('backend.permanent_address'))
                                        ->maxLength(80),
                                    Radio::make('gender')
                                        ->label(__('backend.gender'))
                                        ->options(GenderEnum::getOptions())
                                        ->required()
                                        ->inline(true),
                                    DatePicker::make('date_of_birth')
                                        ->label(__('backend.date_of_birth'))
                                        ->minDate(now()->subYears(40)),
                                ]), // End Basic info
                            Tab::make(ucfirst(__('backend.guardian_info')))
                                ->icon(Heroicon::User)
                                ->columns(2)
                                ->schema([
                                    TextInput::make('guardian_name')->label(__('backend.guardian_name'))->maxLength(65),
                                    Select::make('guardian_relationship')
                                        ->label(__('backend.relation_title'))
                                        ->options(GuardianRelationshipEnum::getOptions())
                                        ->preload()
                                        ->searchable(),
                                    TextInput::make('guardian_job')->label(__('backend.guardian_job'))->maxLength(65),
                                    TextInput::make('guardian_phone')
                                        ->label(__('backend.guardian_phone'))
                                        ->maxLength(14),
                                ]), // End Guardian info
                        ]), // End Tabs

                        Section::make(ucfirst(__('backend.academic_info')))
                            ->visibleOn('create')
                            ->compact()
                            ->columns(2)
                            ->icon(Heroicon::AcademicCap)
                            ->schema([
                                Select::make('acceptance_type_id')
                                    ->label(__('backend.acceptance_type'))
                                    ->options(AcceptanceType::active()->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('academic_status_id')
                                    ->label(__('backend.academic_status'))
                                    ->options(
                                        AcademicStatus::enabled()->orderBy('sort_order', 'ASC')->pluck('name', 'id'),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->default(1),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->options(AcademicYear::active()->orderBy('name', 'ASC')->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(fn($get, $set) => $set('batch_id', null)),
                                Select::make('college_id')
                                    ->label(__('backend.college'))
                                    ->options(College::active()->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(fn(Set $set) => $set('department_id', null)),
                                Select::make('department_id')
                                    ->label(__('backend.department'))
                                    ->options(
                                        fn($get) => Department::active()
                                            ->where('college_id', $get('college_id'))
                                            ->pluck('name', 'id'),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000),
                                Select::make('level_id')
                                    ->label(__('backend.level'))
                                    ->options(Level::query()->orderBy('sort_order')->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('batch_id')
                                    ->label(__('backend.batch'))
                                    ->options(function ($get) {
                                        return Batch::where('academic_year_id', $get('academic_year_id'))
                                            ->where('college_id', $get('college_id'))
                                            ->where('department_id', $get('department_id'))
                                            ->get()
                                            ->pluck('NameCollegeYear', 'id');
                                    })
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            FileUpload::make('profile_picture')
                                ->label(__('backend.profile_picture'))
                                ->image()
                                ->maxSize(600)
                                ->directory(fn($record) => 'students/' . $record->university_no . '/profile_pictures')
                                ->visibility('public')
                                ->visibleOn('edit')
                                ->imageEditor(),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Student $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Student $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
