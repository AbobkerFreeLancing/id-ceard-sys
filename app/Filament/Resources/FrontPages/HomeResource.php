<?php

namespace App\Filament\Resources\FrontPages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\FrontPages\HomeResource\Pages\ListHomes;
use App\Filament\Resources\FrontPages\HomeResource\Pages\EditHome;
use App\Filament\Resources\FrontPages\HomeResource\Pages;
use App\Filament\Resources\FrontPages\HomeResource\RelationManagers;
use App\Filament\Resources\FrontPages\HomeResource\RelationManagers\HomeFeaturesRelationManager;
use App\Filament\Resources\FrontPages\HomeResource\RelationManagers\HomeSlidersRelationManager;
use App\Models\HomePage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class HomeResource extends Resource
{
    protected static ?string $model = HomePage::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

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
        return __("backend.home_page");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.home_page");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.home_page"));
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
                TextInput::make('title')->label(__('backend.title'))->maxLength(20)->required()->columnSpan('full'),
                Fieldset::make(__('backend.categories_alt'))->schema([
                    // TextInput::make('categories_title')->label(__('backend.title'))->required()->columnSpanFull(),
                    // TextInput::make('categories_subtitle')->label(__('backend.subtitle'))->required()->columnSpanFull(),
                    Select::make('category_id')->label(__('backend.categories_alt'))->multiple()->required()
                    ->relationship('home_categories', 'name')->preload()->searchable()->columnSpanFull(),
                ]),
                Select::make('collection_id')->label(__('backend.collections'))->multiple()->required()
                ->relationship('home_collections', 'name')->maxItems(2)->minItems(2)
                ->preload()->searchable()->columnSpanFull(),
            ]),
            
            ])->columnSpan(['lg' => 2]),
            Group::make()->schema([
                Section::make('SEO')->schema([
                    Textarea::make('meta_title')->rows(2)->label(__('backend.meta_title'))->maxLength(80)->columnSpanFull(),
                    Textarea::make('meta_description')->rows(2)->label(__('backend.meta_description'))->maxLength(100)->columnSpanFull(),
                    Textarea::make('meta_keywords')->rows(2)->label(__('backend.meta_keywords'))->maxLength(80)->columnSpanFull(),
                    FileUpload::make('meta_image')->label(__('backend.meta_image'))->image()->maxFiles(1),
                ]),
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
            'index' => ListHomes::route('/'),
            // 'create' => Pages\CreateHome::route('/create'),
            'edit' => EditHome::route('/{record}/edit'),
        ];
    }
}
