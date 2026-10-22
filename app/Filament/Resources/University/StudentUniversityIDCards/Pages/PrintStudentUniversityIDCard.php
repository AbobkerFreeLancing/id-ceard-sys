<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Pages;

use App\Filament\Resources\University\Students\StudentResource;
use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class PrintStudentUniversityIDCard extends ViewRecord
{
    protected static string $resource = StudentUniversityIDCardResource::class;

    protected string $view = 'filament.resources.university.student-university-id-cards.pages.print-student-university-id-card';

    public function getTitle(): string
    {
        return __('backend.university_id_card');
    }

    public function getQrCodeDataUri(): string
    {
        $record = $this->getRecord();
        $payload = $record->ref_number ?: (string) $record->getKey();

        return new QRCode(
            new QROptions([
                'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                'scale' => 5,
            ]),
        )->render($payload);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label(__('backend.print'))
                ->icon(Heroicon::Printer)
                ->action(fn() => $this->js('window.print()')),

            Action::make('flip_card_horz')
                ->label(__('backend.flip_direction'))
                ->icon(Heroicon::ArrowsRightLeft)
                ->color('gray')
                ->action(
                    fn() => $this->js(
                        "(() => { const card = document.querySelector('.student-id-card'); if (!card) return; card.style.transform = card.style.transform === 'scaleX(-1)' ? '' : 'scaleX(-1)'; })()",
                    ),
                ),

            Action::make('view_student_profile')
                ->label(__('backend.student_profile'))
                ->icon(Heroicon::UserCircle)
                ->color('gray')
                ->url(fn() => StudentResource::getUrl('view', [$this->getRecord()->student->id])),
        ];
    }
}
