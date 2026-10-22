<?php

namespace App\Filament\Commands\FileGenerators\Resources;

use Filament\Commands\FileGenerators\Resources\Schemas\ResourceFormSchemaClassGenerator;
use Nette\PhpGenerator\ClassType;

class BedayaFormGenerator extends ResourceFormSchemaClassGenerator
{
    protected function addMethodsToClass(ClassType $class): void
    {
        parent::addMethodsToClass($class);

        if ($class->hasMethod('configure')) {
            $formMethod = $class->getMethod('configure');

            $this->namespace->addUse('Filament\Schemas\Schema');
            $this->namespace->addUse('Filament\Schemas\Components\Utilities\Get');
            $this->namespace->addUse('Filament\Schemas\Components\Utilities\Set');
            $this->namespace->addUse('Filament\Schemas\Components\Group');
            $this->namespace->addUse('Filament\Schemas\Components\Section');
            $this->namespace->addUse('Filament\Forms\Components\TextInput');
            $this->namespace->addUse('Filament\Forms\Components\Textarea');
            $this->namespace->addUse('Filament\Forms\Components\DatePicker');
            $this->namespace->addUse('Filament\Forms\Components\Radio');
            $this->namespace->addUse('Filament\Forms\Components\Select');
            $this->namespace->addUse('Filament\Infolists\Components\TextEntry');
            $this->namespace->addUse('Filament\Support\Icons\Heroicon');

            $modelName = 'Model_X_Name';

            $formContent = <<<PHP
            return \$schema
                ->components([
                    Group::make()
                        ->schema([
                            Section::make()
                                ->compact()
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('backend.name'))
                                        ->maxLength(80)
                                        ->required()
                                        ->unique(ignoreRecord: true),
                                    // Select::make('xxx_id')
                                    //     ->label(__('backend.xxx'))
                                    //     ->relationship('xxx', 'name')
                                    //     ->preload()
                                    //     ->searchable()
                                    //      ->required(),
                                ])->columns(2)
                        ])->columnSpan(['lg' => 2]),
                    Group::make()->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                TextEntry::make('created_at')->label(__('backend.created_at'))
                                    ->state(fn({$modelName} \$record): ?string => \$record->created_at?->diffForHumans())
                                    ->hidden(fn(?{$modelName} \$record) => \$record === null),
                                TextEntry::make('updated_at')->label(__('backend.updated_at'))
                                    ->state(fn({$modelName} \$record): ?string => \$record->updated_at?->diffForHumans())
                                    ->hidden(fn(?{$modelName} \$record) => \$record === null),
                            ])
                    ]),
                ])->columns(3);
            PHP;

            $formMethod->setBody($formContent);
        }
    }
}
