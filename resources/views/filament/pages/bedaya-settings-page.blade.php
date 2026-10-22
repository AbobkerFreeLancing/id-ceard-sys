@php
use App\Filament\Resources\Medical\FloorResource;
use App\Filament\Resources\Medical\RoomResource;
use App\Filament\Resources\Medical\MedicalServiceResource;
use App\Filament\Resources\Medical\OperationResource;
use App\Filament\Resources\Medical\LabTests\LabTestResource;
use App\Filament\Resources\Medical\ImagingResource;
use App\Filament\Resources\Accounting\ExpenseTypeResource;
use App\Filament\Resources\Accounting\FinancialYearResource;
use App\Filament\Resources\Accounting\CurrencyResource;
@endphp
<x-filament-panels::page class="padd-zero bedaya_settings_page">
@if(config('bedaya.accounting_enabled'))
{{-- Medical Module --}}
<main class="sys-card py-8 bg-white px-4 my-1 rounded-lg shadow">
        <h3 class="text-xl mb-4">{{ __('backend.financial_accounts') }}</h3>
        <section class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
            @if(auth()->user()->can('expense_management') && config('bedaya.accounting_enabled'))
            <x-link-widget :title="__('backend.expense_types')" :url="ExpenseTypeResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-rectangle-stack" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif

            @if(auth()->user()->can('financial_years_management') && config('bedaya.accounting_enabled'))
            <x-link-widget :title="__('backend.financial_years')" :url="FinancialYearResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-flag" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif

            @if(auth()->user()->can('currencies_list') && config('bedaya.accounting_enabled'))
            <x-link-widget :title="__('backend.currencies')" :url="CurrencyResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-currency-dollar" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif
        </section>
</main>
@endif

@if(config('bedaya.medical_enabled') || config('bedaya.lab_enabled'))
{{-- Medical Module --}}
<main class="sys-card py-8 bg-white px-4 my-1 rounded-lg shadow">
        <h3 class="text-xl mb-4">{{ __('backend.medical_module') }}</h3>
        <section class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

            {{-- @if(auth()->user()->can('floor_management') && config('bedaya.medical_enabled'))
            <x-link-widget :title="__('backend.floors')" :url="FloorResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-queue-list" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif

             @if(auth()->user()->can('room_management') && config('bedaya.medical_enabled'))
            <x-link-widget :title="__('backend.rooms')" :url="RoomResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-building-library" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif --}}

            @if(auth()->user()->can('medical_services_management') && config('bedaya.medical_enabled'))
            <x-link-widget :title="__('backend.medical_services')" :url="MedicalServiceResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-clipboard-document" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif

            {{-- @if(auth()->user()->can('operation_management') && config('bedaya.medical_enabled'))
            <x-link-widget :title="__('backend.operations')" :url="OperationResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-scissors" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif --}}

            @if(auth()->user()->can('lab_tests_list') && config('bedaya.lab_enabled'))
            <x-link-widget :title="__('backend.lab_test_types')" :url="LabTestResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-beaker" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif

            @if(auth()->user()->can('imaging_management') && config('bedaya.medical_enabled'))
            <x-link-widget :title="__('backend.imagings')" :url="ImagingResource::getUrl('index')">
                <x-slot name="icon">
                    <x-filament::icon icon="heroicon-o-rectangle-group" class="size-6 text-primary-500"/>
                </x-slot>
            </x-link-widget>
            @endif
        </section>
</main>
@endif

<style>
.bedaya_settings_page header.fi-header .fi-header-heading {
 font-size: 1.5rem !important
}
</style>
</x-filament-panels::page>