<?php

namespace App\Filament\Resources\Common\Devs\Schemas;

use Packages\Common\Models\Dev;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DevForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            Toggle::make('on_demo_mode')->label(__('backend.demo_mode'))->inline(false),
                            ColorPicker::make('admin_color_hex')->label(__('backend.color'))->required(),
                            // #ea304d
                        ])->columns(3),
                        Section::make()
                            ->columns(3)
                            ->schema([
                                FileUpload::make('admin_logo')
                                    ->label(__('backend.logo'))
                                    ->image()
                                    ->directory('admin-logo')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn(TemporaryUploadedFile $file): string => (string) str(
                                            $file->getClientOriginalName(),
                                        )->prepend('bedaya-'),
                                    ),
                                FileUpload::make('website_favicon')
                                    ->label('Website Favicon')
                                    ->image()
                                    ->maxSize(100)
                                    ->directory('website_favicon'),
                                TextInput::make('logo_height')->minValue(25)->maxValue(75)->required()->numeric(),
                                TextEntry::make('updated_at')
                                    ->label(__('backend.updated_at'))
                                    ->state(fn(Dev $record): ?string => $record->updated_at?->diffForHumans())
                                    ->hidden(fn(?Dev $record) => $record === null),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.invoice_logo'))->schema([
                        FileUpload::make('invoice_logo')
                            ->label(__('backend.invoice_logo'))
                            ->image()
                            ->directory('invoice-logo')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str(
                                    $file->getClientOriginalName(),
                                )->prepend('bedaya-'),
                            ),
                        TextInput::make('invoice_logo_height')
                            ->label(__('backend.invoice_logo_height'))
                            ->minValue(10)
                            ->maxValue(1000)
                            ->required()
                            ->numeric(),
                    ]),
                ]),
            ])
            ->columns(3);
    }
}
