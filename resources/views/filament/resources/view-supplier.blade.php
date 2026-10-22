<x-filament-panels::page>
<div>
{{-- -------------- --}}
<section class="bg-white rounded-lg p-4 shadow-sm">
    <h3>{{ $record->name }}</h3>
    {{-- <p>{{ __('backend.debit') }}: {{$record->account->debit}} &nbsp;&nbsp;&nbsp; {{ __('backend.credit') }}: {{ $record->account->credit }}</p> --}}
    <p>{{ __('backend.balance') }}: 
        <strong style="direction: ltr;unicode-bidi: plaintext">{{number_format($record->account->balance,2)}}</strong> 
        {{ $record->account->currency->symbol}}
    </p>
</section>
{{-- -------------- --}}
</div>

{{-- ------------------------------------- --}}
@php $relationManagers = $this->getRelationManagers() @endphp

<filament-panels::resources.relation-managers 
            :active-manager="$this->activeRelationManager"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        >
        @if ($this->hasCombinedRelationManagerTabsWithContent())
            <x-slot name="form">
                {{ $this->form }}
            </x-slot>
        @endif
</filament-panels::resources.relation-managers>
{{-- ------------------------------------- --}}
</x-filament-panels::page>
{{--
@push('scripts')
    <script>
        Livewire.on('print', () => {
            window.print()
        })
    </script>
@endpush --}}