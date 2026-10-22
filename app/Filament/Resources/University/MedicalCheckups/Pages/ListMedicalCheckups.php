<?php

namespace App\Filament\Resources\University\MedicalCheckups\Pages;

use App\Filament\Resources\University\MedicalCheckups\MedicalCheckupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Packages\University\Enums\MedicalCheckupStatusEnum;
use Packages\University\Models\MedicalCheckup;

class ListMedicalCheckups extends ListRecords
{
    protected static string $resource = MedicalCheckupResource::class;

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('backend.view_all')),
            __('backend.pending') => Tab::make()
                ->query(fn($query) => $query->where('status', MedicalCheckupStatusEnum::Pending->value))
                ->badge(MedicalCheckup::where('status', MedicalCheckupStatusEnum::Pending->value)->count())
                ->badgeColor('gray'),

            __('backend.under_review') => Tab::make()
                ->query(fn($query) => $query->where('status', MedicalCheckupStatusEnum::UnderReview->value))
                ->badge(MedicalCheckup::where('status', MedicalCheckupStatusEnum::UnderReview->value)->count())
                ->badgeColor('info'),

            __('backend.fit') => Tab::make()
                ->query(fn($query) => $query->where('status', MedicalCheckupStatusEnum::Fit->value))
                ->badge(MedicalCheckup::where('status', MedicalCheckupStatusEnum::Fit->value)->count())
                ->badgeColor('success'),

            __('backend.unfit') => Tab::make()
                ->query(fn($query) => $query->where('status', MedicalCheckupStatusEnum::UnFit->value))
                ->badge(MedicalCheckup::where('status', MedicalCheckupStatusEnum::UnFit->value)->count())
                ->badgeColor('danger'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->hidden(),
        ];
    }
}
