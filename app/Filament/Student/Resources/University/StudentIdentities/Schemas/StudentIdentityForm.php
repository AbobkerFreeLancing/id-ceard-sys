<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
use Packages\University\Enums\IdentityTypeEnum;
use Packages\University\Models\StudentIdentity;

class StudentIdentityForm
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
                                FileUpload::make('attachment')
                                    ->image()
                                    ->required()
                                    ->columnSpanFull()
                                    ->directory(
                                        fn($livewire) => 'students/' .
                                            $livewire->ownerRecord->university_no .
                                            '/identities',
                                    )
                                    ->maxFiles(1)
                                    ->maxSize(1024)
                                    ->label(__('backend.attachment')),
                                Select::make('type')
                                    ->label(__('backend.type'))
                                    ->required()
                                    ->options(IdentityTypeEnum::getOptions())
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull(),
                                TextInput::make('notes')->maxLength(100)->label(__('backend.notes'))->columnSpanFull(),
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
                                ->state(fn(StudentIdentity $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?StudentIdentity $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(StudentIdentity $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?StudentIdentity $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
