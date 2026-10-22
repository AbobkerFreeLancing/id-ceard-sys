<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end">
            <x-filament::button type="submit" color="primary" wire:loading.attr="disabled" wire:target="submit">
                {{ __('backend.apply_fee_structure') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
