<div class=" flex items-center relative px-3 overflow-hidden transition-all border border-gray-100 shadow duration-200 bg-gray-50 rounded-xl hover:bg-gray-100">
    <div class="p-3 lg:px-2 lg:py-2">
        <div class="flex items-center justify-start gap-x-2">
            {{ $icon }}
            <div class="flex-shrink-0 w-px h-8 bg-gray-200"></div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 sm:text-base">
                    <a href="{{ $url }}">
                        {{ $title }}
                        <span class="absolute inset-0" aria-hidden="true"></span>
                    </a>
                </h3>
                {{-- <p class="mt-2 text-sm font-medium text-gray-500">{{ $subtitle }}</p> --}}
            </div>
        </div>
    </div>
</div>