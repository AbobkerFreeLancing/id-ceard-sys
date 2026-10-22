<section class="py-2">
    <div class="container">
        @if ($block['type'] == "heading")
        <h3 class="m-0 text-xl text-primary-800">{{ $block['data']['title'] }}</h3>
        @endif
        
        @if ($block['type'] == "paragraph")
        <div class="max-w-4xl">{!! $block['data']['paragraph'] !!}</div>
        @endif
        </div>
</section>