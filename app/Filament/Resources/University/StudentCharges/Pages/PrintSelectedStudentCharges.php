<?php

namespace App\Filament\Resources\University\StudentCharges\Pages;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Url;

class PrintSelectedStudentCharges extends Page
{
    protected static string $resource = StudentChargeResource::class;

    protected string $view = 'filament.resources.university.student-charges.pages.print-selected-student-charges';

    #[Url]
    public string $records = '';

    public function getTitle(): string
    {
        return __('backend.print_selected_charges');
    }

    protected function getViewData(): array
    {
        $recordIds = explode(',', $this->records);

        abort_if(
            $this->records === '' || collect($recordIds)->contains(fn (string $id): bool => ! ctype_digit($id)),
            404,
        );

        $recordIds = array_values(array_unique($recordIds));
        $recordPositions = array_flip($recordIds);
        $charges = StudentChargeResource::getEloquentQuery()
            ->with([
                'student',
                'feeType',
                'feeStructure.college',
                'feeStructure.level',
                'academicYear',
                'currency',
            ])
            ->whereKey($recordIds)
            ->get()
            ->sortBy(fn ($charge): int => $recordPositions[(string) $charge->getKey()])
            ->values();

        abort_unless($charges->count() === count($recordIds), 404);

        return ['charges' => $charges];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label(__('backend.print'))
                ->icon('heroicon-o-printer')
                ->action(fn () => $this->js('window.print()')),
        ];
    }
}
