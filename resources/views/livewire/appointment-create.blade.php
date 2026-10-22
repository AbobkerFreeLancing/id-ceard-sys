<div>
    <section class="md:max-w-2xl">
        <form wire:submit="create">
        {{ $this->form }}
            <x-filament::button class="my-2 px-4 bg-primary-500 hover:bg-primary-600 focus:bg-primary-600" type="submit" wire:click.prevent="create">
                {{ __('backend.action_create') }}
            </x-filament::button>
    </form>
    </section>
</div>