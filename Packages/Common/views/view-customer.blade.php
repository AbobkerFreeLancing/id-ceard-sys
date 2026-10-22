<x-filament-panels::page>
<div>
{{-- -------------- --}}
<section class="bg-white rounded-lg p-4 shadow-sm">
    <h3>{{ $record->name }}</h3>
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