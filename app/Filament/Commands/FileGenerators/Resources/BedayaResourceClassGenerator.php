<?php

namespace App\Filament\Commands\FileGenerators\Resources;

use Filament\Commands\FileGenerators\Resources\ResourceClassGenerator;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;

class BedayaResourceClassGenerator extends ResourceClassGenerator
{
    protected function addPropertiesToClass(ClassType $class): void
    {
        parent::addPropertiesToClass($class);

        // $this->namespace->addUse(\Online\Hoza::class);

        $class->addProperty('navigationSort', 10)
            ->setProtected()
            ->setStatic()
            ->setType('?int');
    }

    protected function addMethodsToClass(ClassType $class): void
    {
        // getNavigationGroup   
        $class->addMethod('getNavigationGroup')
            ->setPublic()
            ->setStatic()
            ->setReturnType('string')
            ->setBody('return __(\'backend.nav_module\');');

        // getLabel
        $class->addMethod('getLabel')
            ->setPublic()
            ->setStatic()
            ->setReturnType('?string')
            ->setBody('return __(\'backend.single\');');

        // getPluralLabel
        $class->addMethod('getPluralLabel')
            ->setPublic()
            ->setStatic()
            ->setReturnType('?string')
            ->setBody('return __(\'backend.singles\');');

        // getNavigationLabel
        $class->addMethod('getNavigationLabel')
            ->setPublic()
            ->setStatic()
            ->setReturnType('string')
            ->setBody('return __(\'backend.singles\');');

        // shouldRegisterNavigation
        $class->addMethod('shouldRegisterNavigation')
            ->setPublic()
            ->setStatic()
            ->setReturnType('bool')
            ->setBody('return true;');

        // canAccess
        $class->addMethod('canAccess')
            ->setPublic()
            ->setStatic()
            ->setReturnType('bool')
            ->setBody('return true;');

        parent::addMethodsToClass($class);
    }

    protected function addNavigationIconPropertyToClass(ClassType $class): void
    {
        $this->namespace->addUse(BackedEnum::class);
        $this->namespace->addUse(Heroicon::class);

        $property = $class->addProperty('navigationIcon', new Literal('Heroicon::OutlinedPuzzlePiece'))
            ->setProtected()
            ->setStatic()
            ->setType('string|BackedEnum|null');
        $this->configureNavigationIconProperty($property);
    }
}
