<x-filament-panels::page>

{{ $this->form}}

<x-filament::button type="submit" wire:click="AddOpeningBalance">
    {{ __('backend.action_save_settings') }}
</x-filament::button>

</x-filament-panels::page>