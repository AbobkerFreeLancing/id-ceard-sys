<?php

namespace App\Livewire;

use Packages\Medical\Models\Doctor;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class AppointmentCreate extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?string $name;
    public ?string $phone;
    public ?string $reason_for_visit;
    public ?int $doctor_id;
    public ?int $total;
    public ?int $net_total;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('backend.appointment_booking'))
                    ->icon('heroicon-o-bookmark-square')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('backend.name'))
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('backend.phone'))
                            ->required(),
                        Select::make('doctor_id')
                            ->options(Doctor::get()->pluck('name_clinic', 'id'))
                            ->label(__('backend.the_doctor'))
                            ->live(1000)
                            ->required()
                            ->preload()
                            ->searchable(),
                        TextEntry::make('price_only')
                            ->label(__('backend.appointment_fees'))
                            ->state(function (Get $get, Set $set) {
                                if ($get('doctor_id') != NULL) {
                                    $appointment_fees = Doctor::find($get('doctor_id'))->appointment_fees;
                                    $set('total', ($appointment_fees));
                                    $set('net_total', ($appointment_fees));
                                    return number_format($appointment_fees, 2);
                                }
                                return 0;
                            }),
                        Hidden::make('total'),
                        Hidden::make('net_total'),
                        Textarea::make('reason_for_visit')
                            ->label(function () {
                                return __('backend.reason_for_visit') . ' / ' . __('backend.symptoms');
                            })->required()
                            ->rows(2)
                            ->maxLength(300)
                            ->columnSpanFull()
                    ])->columns(2)
            ]);
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.appointment-create')->layout('layouts.frontend');
    }
}
