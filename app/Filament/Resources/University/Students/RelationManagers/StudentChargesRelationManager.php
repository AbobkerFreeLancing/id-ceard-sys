<?php

namespace App\Filament\Resources\University\Students\RelationManagers;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Enum\PaymentStatusEnum;
use Packages\University\Enums\IdentityTypeEnum;

class StudentChargesRelationManager extends RelationManager
{
    protected static string $relationship = 'charges';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.student_charges');
    }

    public static function modelLabel(): ?string
    {
        return __('backend.student_charge');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('backend.students_charges');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            //
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ref_number')
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number')),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => PaymentStatusEnum::tryFrom($state)->getLabel())
                    ->badge()
                    ->color(fn($state) => PaymentStatusEnum::tryFrom($state)->getColor())
                    ->label(__('backend.status')),
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('feeType.name')->label(__('backend.fee_type')),
                TextColumn::make('net_amount')
                    ->label(__('backend.amount'))
                    ->summarize(Sum::make()->formatStateUsing(fn($state) => setMoney($state)))
                    ->formatStateUsing(fn($state) => setMoney($state)),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
                CreateAction::make()->createAnother(false),
            ])
            ->recordActions([
                //
                Action::make('view_charge')
                    ->label(__('backend.action_view'))
                    ->icon(Heroicon::DocumentText)
                    ->button()
                    ->outlined()
                    ->url(fn($record) => StudentChargeResource::getUrl('view', [$record->id])),
                EditAction::make()->hidden(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([]);
    }
}
