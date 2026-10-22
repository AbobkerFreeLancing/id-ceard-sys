<?php

namespace App\Filament\Commands\FileGenerators\Resources\Pages;

use Filament\Support\Commands\FileGenerators\ClassGenerator;
use Nette\PhpGenerator\ClassType;

class BedayaCreateRecordGenerator extends ClassGenerator
{
    protected string $namespaceString = 'App\\Filament\\Resources\\Pages';

    protected function addPropertiesToClass(ClassType $class): void
    {
        $class->addProperty('resource', static::class . '::class')
            ->setProtected()
            ->setStatic()
            ->setType('string');
    }

    public function getBasename(): string
    {
        return class_basename(static::class);
    }

    public function getNamespace(): string
    {
        return $this->namespaceString;
    }

    protected function addMethodsToClass(ClassType $class): void
    {
        $class->addMethod('canCreateAnother')
            ->setPublic()
            ->setReturnType('bool')
            ->setBody('return false;');
    }
}
