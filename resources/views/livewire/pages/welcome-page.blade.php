<div>
<h2>Welcome</h2>
{!! $record->renderRichContent('content') !!}

<button class="btn btn-primary" wire:click="toggleAction">Action Toggle</button>

{{-- <native:bottom-nav>
    <native:bottom-nav-item id="home" icon="home" label="Home" url="/home" />
</native:bottom-nav> --}}

</div>