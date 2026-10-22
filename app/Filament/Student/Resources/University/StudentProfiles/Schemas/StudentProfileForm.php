<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\Enum\Profile\GenderEnum;
use Packages\University\Enums\GuardianRelationshipEnum;
use Packages\University\Models\Student;

class StudentProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Tabs::make()->schema([
                            Tab::make(ucfirst(__('backend.basic_info')))
                                ->icon(Heroicon::InformationCircle)
                                ->columns(2)
                                ->schema([
                                    TextInput::make('address')->label(__('backend.current_address'))->maxLength(80),
                                    TextInput::make('permanent_address')
                                        ->label(__('backend.permanent_address'))
                                        ->maxLength(80),
                                    Radio::make('gender')
                                        ->label(__('backend.gender'))
                                        ->options(GenderEnum::getOptions())
                                        ->required()
                                        ->inline(true),
                                    DatePicker::make('date_of_birth')
                                        ->label(__('backend.date_of_birth'))
                                        ->minDate(now()->subYears(40)),
                                ]), // End Basic info
                            Tab::make(ucfirst(__('backend.guardian_info')))
                                ->icon(Heroicon::User)
                                ->columns(2)
                                ->schema([
                                    TextInput::make('guardian_name')->label(__('backend.guardian_name'))->maxLength(65),
                                    Select::make('guardian_relationship')
                                        ->label(__('backend.relation_title'))
                                        ->options(GuardianRelationshipEnum::getOptions())
                                        ->preload()
                                        ->searchable(),
                                    TextInput::make('guardian_job')->label(__('backend.guardian_job'))->maxLength(65),
                                    TextInput::make('guardian_phone')
                                        ->label(__('backend.guardian_phone'))
                                        ->maxLength(14),
                                ]), // End Guardian info
                        ]), // End Tabs
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            FileUpload::make('profile_picture')
                                ->label(__('backend.profile_picture'))
                                ->image()
                                ->maxSize(600)
                                ->directory(fn($record) => 'students/' . $record->university_no . '/profile_pictures')
                                ->visibility('public')
                                ->visibleOn('edit')
                                ->imageEditor(),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Student $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Student $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
