<?php

namespace App\Filament\Resources\University\StudentCharges\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Enum\PaymentStatusEnum;
use Packages\University\Models\StudentCharge;

class StudentChargeInfolist
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
                                //
                                TextEntry::make('ref_number')->label(__('backend.ref_number')),
                                TextEntry::make('feeType.name')->label(__('backend.fee_type')),
                                TextEntry::make('PaymentsTotal')->label(__('backend.paid')),
                                TextEntry::make('PaymentsRemaining')->label(__('backend.remaining')),
                                TextEntry::make('status')
                                    ->formatStateUsing(fn($state) => PaymentStatusEnum::tryFrom($state)->getLabel())
                                    ->badge()
                                    ->color(fn($state) => PaymentStatusEnum::tryFrom($state)->getColor())
                                    ->label(__('backend.status')),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('student.name')->label(__('backend.student')),
                            TextEntry::make('student.university_no')->label(__('backend.university_no')),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(StudentCharge $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?StudentCharge $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(StudentCharge $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?StudentCharge $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
