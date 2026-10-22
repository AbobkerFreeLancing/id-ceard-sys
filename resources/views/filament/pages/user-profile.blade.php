<x-filament-panels::page class="padd-zero">
<form wire:submit.prevent="updateSettings">

{{ $this->form }}

<x-filament::button class="my-2" type="submit" wire:click.prevent="updateSettings">
    {{ ucfirst(__('backend.action_update')) }}
</x-filament::button>

</form>
</x-filament-panels::page>
