<?php

namespace App\Filament\Commands\FileGenerators\Resources;

use Filament\Commands\FileGenerators\Resources\Schemas\ResourceTableClassGenerator;
use Nette\PhpGenerator\ClassType;

class BedayaTableGenerator extends ResourceTableClassGenerator
{
    protected function addMethodsToClass(ClassType $class): void
    {
        parent::addMethodsToClass($class);

        if ($class->hasMethod('configure')) {
            $formMethod = $class->getMethod('configure');

            $this->namespace->addUse('Illuminate\Database\Eloquent\Builder');
            $this->namespace->addUse('Filament\Tables\Columns\TextColumn');
            $this->namespace->addUse('Filament\Tables\Columns\ToggleColumn');
            $this->namespace->addUse('Filament\Tables\Filters\Filter');
            $this->namespace->addUse('Filament\Forms\Components\DatePicker');
            $this->namespace->addUse('Filament\Tables\Filters\SelectFilter');
            $this->namespace->addUse('Filament\Actions\Action');
            $this->namespace->addUse('Filament\Actions\ViewAction');
            $this->namespace->addUse('Filament\Actions\DeleteAction');
            $this->namespace->addUse('Filament\Actions\ActionGroup');
            $this->namespace->addUse('Filament\Actions\BulkActionGroup');

            $formContent = <<<PHP
            return \$table
                        ->columns([
                            TextColumn::make('name')->label(__('backend.name'))->searchable(),
                            //TextColumn::make('name_en')->label(__('backend.name_en')),
                            // ToggleColumn::make('is_active')->label(__('backend.is_active')),
                            // TextColumn::make('plurs_count')->counts('plurs')->label(__('backend.plurs')),
                            // TextColumn::make('xxx.name')->label(__('backend.xxx')),
                            TextColumn::make('created_at')
                            ->label(__('backend.created_at'))
                            ->date()
                            ->toggleable(isToggledHiddenByDefault: true),
                        ])
                        ->filters([
                            // SelectFilter::make('xxx_id')
                            //     ->label(__('backend.xxx'))
                            //     ->relationship('xxx', 'name')
                            //     ->preload()
                            //     ->searchable(),
                        ])
                        ->recordActions([
                            ViewAction::make()->iconButton(),
                            EditAction::make()->iconButton(),
                            ActionGroup::make([
                                DeleteAction::make()
                            ])
                        ])
                        ->toolbarActions([
                            BulkActionGroup::make([]),
                        ]);
            PHP;

            $formMethod->setBody($formContent);
        }
    }
}
