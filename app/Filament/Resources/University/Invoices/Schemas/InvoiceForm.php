<?php

namespace App\Filament\Resources\University\Invoices\Schemas;

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
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Models\Invoice;

class InvoiceForm
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
                                Select::make('student_id')
                                    ->label(__('backend.student'))
                                    ->relationship('student', 'full_name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship('academicYear', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('college_id')
                                    ->label(__('backend.college'))
                                    ->relationship('college', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('level_id')
                                    ->label(__('backend.level'))
                                    ->relationship('level', 'name', fn(Builder $query) => $query->orderBy('sort_order'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('semester_id')
                                    ->label(__('backend.semester'))
                                    ->relationship('semester', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('currency_id')
                                    ->label(__('backend.currency'))
                                    ->relationship('currency', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('bank_id')
                                    ->label(__('backend.bank'))
                                    ->relationship('bank', 'name', fn($query) => $query->where('is_active', true))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                TextInput::make('total')->label(__('backend.total'))->numeric()->required(),
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
                                ->state(fn(Invoice $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Invoice $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Invoice $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Invoice $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
