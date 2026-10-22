<?php

namespace App\Filament\Resources\Common\Contracts\Schemas;

use Packages\Common\Models\Contract;
use Packages\HR\Enum\EmploymentStatusEnum;
use Packages\HR\Enum\EmploymentTypeEnum;
use Packages\Payroll\Models\SalaryStructure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            Select::make('user_id')
                                ->label(__('backend.employee'))
                                ->relationship('user', 'name')
                                ->preload()
                                ->searchable()
                                ->required(),
                            Select::make('type')
                                ->label(__('backend.contract_type'))
                                ->options(EmploymentTypeEnum::getOptions())
                                ->default(EmploymentTypeEnum::Fulltime->value)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Select::make('salary_structure_id')
                                ->label(__('backend.salary_structure'))
                                ->relationship('salaryStructure', 'name')
                                ->preload()
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (Set $set, $state) {
                                    if ($state) {
                                        $salaryStructure = SalaryStructure::find($state);
                                        $set('basic_salary', $salaryStructure->basic_salary);
                                    } else {
                                        $set('basic_salary', null);
                                    }
                                }),
                            TextInput::make('basic_salary')->label(__('backend.basic_salary'))->numeric()->required(),
                            DatePicker::make('start_date')
                                ->label(__('backend.start_date'))
                                // ->minDate(now()->sub)
                                ->default(now())
                                ->required(),
                            DatePicker::make('end_date')->label(__('backend.end_date'))->after('start_date'),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            Select::make('status')
                                ->label(__('backend.status'))
                                ->options(EmploymentStatusEnum::getOptions(['terminated']))
                                ->default(EmploymentStatusEnum::Active->value)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Textarea::make('notes')
                                ->label(__('backend.notes'))
                                ->rows(2)
                                ->maxLength(300)
                                ->columnSpanFull(),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Contract $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Contract $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Contract $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Contract $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
