<?php

namespace App\Filament\Resources\FrontPages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\FrontPages\FrontSettingsResource\Pages\ListFrontSettings;
use App\Filament\Resources\FrontPages\FrontSettingsResource\Pages\EditFrontSettings;
use App\Filament\Resources\FrontPages\FrontSettingsResource\Pages;
use App\Filament\Resources\FrontPages\FrontSettingsResource\RelationManagers;
use App\Models\FrontSettings;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class FrontSettingsResource extends Resource
{
    protected static ?string $model = FrontSettings::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return __("backend.pages");
    }

    public static function getLabel(): ?string
    {
        return __("backend.settings");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.settings");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.settings"));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.front_pages_dash');
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->components([
            Group::make()->schema([
                Section::make([
                TextInput::make('site_name')->label(__('backend.company_name'))
                ->maxLength(70)->required()->columnSpan('full'),
                ])
            ])->columnSpan(['lg' => 2]),
            Group::make()->schema([
                Section::make([
                    TextEntry::make('updated_at')->label(__('backend.updated_at'))
                    ->state(fn (FrontSettings $record): ?string => $record->updated_at?->diffForHumans())
                    ->hidden(fn (?FrontSettings $record) => $record === null),
                ])
            ]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')->label(__('backend.company_name'))->searchable(),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([
                Filter::make('created_at')
                ->schema([
                    DatePicker::make('created_from')->native(false)->label(__('backend.creation_date_from')),
                    DatePicker::make('created_until')->native(false)->label(__('backend.creation_date_to'))->default(now()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when($data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFrontSettings::route('/'),
            // 'create' => Pages\CreateFrontSettings::route('/create'),
            'edit' => EditFrontSettings::route('/{record}/edit'),
        ];
    }
}
