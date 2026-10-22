<?php

namespace App\Filament\Resources\Common\Branches\Pages;

use App\Filament\Resources\Common\Branches\BranchResource;
use Packages\Common\Models\Branch;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->visible(Branch::count() < config('bedaya.branch_count'))];
    }
}
