<?php

namespace App\Filament\Resources\FrontPages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\FrontPages\ContactResource\Pages\ListContacts;
use App\Filament\Resources\FrontPages\ContactResource\Pages\EditContact;
use App\Filament\Resources\FrontPages\ContactResource\Pages;
use App\Filament\Resources\FrontPages\ContactResource\RelationManagers;
use App\Models\ContactPage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class ContactResource extends Resource
{
    protected static ?string $model = ContactPage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __("backend.pages");
    }

    public static function getLabel(): ?string
    {
        return __("backend.contact_us");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.contact_us");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.contact_us"));
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
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->components([
            Group::make()->schema([
                Section::make([
                TextInput::make('title')->label(__('backend.title'))->maxLength(50)->required()->columnSpan('full'),
                TextInput::make('subtitle')->label(__('backend.subtitle'))->maxLength(150)->columnSpan('full'),
                Textarea::make('address')->label(__('backend.address'))->maxLength(150)->rows(2)->columnSpan('full'),
                TextInput::make('email')->label(__('backend.email'))->maxLength(100),
                TextInput::make('phones')->label(__('backend.phones'))->maxLength(150),
                ])->columns(2)
            ])->columnSpan(['lg' => 2]),
            Group::make()->schema([
                Section::make([
                    TextEntry::make('updated_at')->label(__('backend.updated_at'))
                    ->state(fn (ContactPage $record): ?string => $record->updated_at?->diffForHumans())
                    ->hidden(fn (?ContactPage $record) => $record === null),
                ])
            ]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(__('backend.title'))->searchable(),
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
            'index' => ListContacts::route('/'),
            // 'create' => Pages\CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}
