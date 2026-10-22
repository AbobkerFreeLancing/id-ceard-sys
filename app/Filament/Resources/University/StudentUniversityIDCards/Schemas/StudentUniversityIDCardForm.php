<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\College;
use Packages\University\Models\Level;
use Packages\University\Models\Student;
use Packages\University\Models\StudentUniversityIDCard;

class StudentUniversityIDCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                Select::Make('college_id')
                                    ->label(__('backend.college'))
                                    ->options(College::active()->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set) => $set('student_id', null)),
                                Select::Make('level_id')
                                    ->label(__('backend.level'))
                                    ->options(Level::pluck('name', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set) => $set('student_id', null)),
                                Select::Make('student_id')
                                    ->label(__('backend.student'))
                                    ->options(function (Get $get) {
                                        $collegeId = $get('college_id');
                                        $levelId = $get('level_id');

                                        if (!$collegeId || !$levelId) {
                                            return [];
                                        }

                                        return Student::whereHas('academicRecords', function ($query) use (
                                            $collegeId,
                                            $levelId,
                                        ) {
                                            $query->where('college_id', $collegeId)->where('level_id', $levelId);
                                        })
                                            ->get()
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled(fn(Get $get) => !$get('college_id') || !$get('level_id'))
                                    ->helperText(
                                        fn(Get $get) => !$get('college_id') || !$get('level_id')
                                            ? 'يرجى اختيار الكلية والمستوى أولاً'
                                            : null,
                                    ),
                                DatePicker::make('issue_date')
                                    ->label(__('backend.issue_date'))
                                    ->default(now())
                                    ->required()
                                    ->visibleOn('edit'),
                                DatePicker::make('expiry_date')
                                    ->label(__('backend.expire_date'))
                                    ->required()
                                    ->visibleOn('edit'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(
                                    fn(
                                        StudentUniversityIDCard $record,
                                    ): ?string => $record->created_at?->diffForHumans(),
                                )
                                ->hidden(fn(?StudentUniversityIDCard $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(
                                    fn(
                                        StudentUniversityIDCard $record,
                                    ): ?string => $record->updated_at?->diffForHumans(),
                                )
                                ->hidden(fn(?StudentUniversityIDCard $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
