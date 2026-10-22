<?php

namespace App\Filament\Resources\Common\Contracts\Schemas;

use Filament\Schemas\Schema;

class ContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
