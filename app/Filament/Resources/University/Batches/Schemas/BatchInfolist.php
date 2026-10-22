<?php

namespace App\Filament\Resources\University\Batches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\University\Models\Batch;

class BatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')->label(__('backend.name')),
                                TextEntry::make('college.name')->label(__('backend.college')),
                                TextEntry::make('code')->label(__('backend.code')),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('department.name')->label(__('backend.department')),
                                // TextEntry::make('students_count')->counts('students')->label(__('backend.students')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Batch $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Batch $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Batch $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Batch $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
