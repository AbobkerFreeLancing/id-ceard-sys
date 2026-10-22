<x-filament::page class="padd-zero">
<form wire:submit.prevent="updatePassword">

{{ $this->form }}

<x-filament::button class="my-2" type="submit" wire:click.prevent="updatePassword">
    {{ __('backend.update_password') }}
</x-filament::button>

</form>
</x-filament::page>
