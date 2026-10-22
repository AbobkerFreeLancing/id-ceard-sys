<div {{ $attributes->merge(['class' => 'shadow-md flex items-center gap-x-4 p-2 py-2 lg:px-4 bg-white rounded-xl']) }}>
    <div class="flex flex-shrink-0 items-center justify-center bg-primary-100 border border-primary-200 h-10 w-10 rounded-full">
        @php $component = "tabler-{$icon}"; @endphp
        <x-dynamic-component :component="$component" class="w-6 h-6 text-primary-700" />
    </div>
    <div class="flex-grow flex flex-col">
        <div class="flex items-center justify-between">
            <span class="text-gray-600 text-sm lg:text-base font-medium">{{ $title }}</span>
        </div>
        <span class="text-2xl text-gray-800 font-semibold">{{ $subtitle }}</span>
    </div>
</div>
