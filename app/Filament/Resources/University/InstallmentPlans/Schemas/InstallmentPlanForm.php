<?php

namespace App\Filament\Resources\University\InstallmentPlans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\FeeStructure;
use Packages\University\Models\InstallmentPlan;

class InstallmentPlanForm
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
                                TextInput::make('name')
                                    ->label(__('backend.name'))
                                    ->maxLength(50)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('fee_structure_id')
                                    ->label(__('backend.fee_structure'))
                                    ->options(
                                        FeeStructure::where('is_approved', true)
                                            ->get()
                                            ->pluck('college_academic', 'id'),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required(),
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
                                ->state(fn(InstallmentPlan $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?InstallmentPlan $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(InstallmentPlan $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?InstallmentPlan $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
