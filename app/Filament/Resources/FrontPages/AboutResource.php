<?php

namespace App\Filament\Resources\FrontPages;

use Filament\Forms;
use Filament\Tables;
use App\Models\AboutPage;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Builder as FilaBuilder;
use App\Filament\Resources\FrontPages\AboutResource\Pages;
use App\Filament\Resources\FrontPages\AboutResource\Pages\EditAbout;
use App\Filament\Resources\FrontPages\AboutResource\Pages\ListAbouts;
use App\Filament\Resources\FrontPages\AboutResource\RelationManagers;
use App\Filament\Resources\FrontPages\AboutResource\RelationManagers\AboutTestimonialsRelationManager;

class AboutResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->orderBy('created_at', 'DESC');
    }

    public static function getNavigationGroup(): string
    {
        return __("backend.pages");
    }

    public static function getLabel(): ?string
    {
        return __("backend.about_us");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.about_us");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.about_us"));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.front_pages_dash');
    }

    public static function canCreate(): bool
    {
        return false;
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
                TextInput::make('title')->label(__('backend.title'))->maxLength(70)->required()->columnSpan('full'),
                TextInput::make('subtitle')->label(__('backend.subtitle'))->maxLength(150)->columnSpan('full'),
                RichEditor::make('content')->label(__('backend.content'))->required(),
                ])
            ])->columnSpan(['lg' => 2]),
            Group::make()->schema([
                Section::make([
                    FileUpload::make('image')->required()->label(__('backend.image')),
                    TextEntry::make('updated_at')->label(__('backend.updated_at'))
                    ->state(fn (AboutPage $record): ?string => $record->updated_at?->diffForHumans())
                    ->hidden(fn (?AboutPage $record) => $record === null),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbouts::route('/'),
            // 'create' => Pages\CreateAbout::route('/create'),
            'edit' => EditAbout::route('/{record}/edit'),
        ];
    }
}
