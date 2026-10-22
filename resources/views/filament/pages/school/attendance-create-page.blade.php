<x-filament-panels::page class="padd-zero">
    {{ $this->form }}
    {{-- @if (!is_null($classroom_id) && !is_null($phase_id) && !is_null($grade_id)) --}}
    {{ $this->table }}
    {{-- @endif --}}
</x-filament-panels::page>
