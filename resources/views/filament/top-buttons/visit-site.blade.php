@php
    use Illuminate\Support\Facades\Route;
@endphp
<div class="flex justify-end px-0">
    <a href="{{ Route::has('home') ? route('home') : '' }}" target="_blank" class="inline-flex justify-center items-center gap-x-2 border font-semibold focus:outline-none px-2 py-1 text-sm rounded-lg border-gray-300 text-gray-600 shadow-sm hover:text-gray-700 hover:border-gray-300 hover:shadow focus:ring-1 focus:ring-primary-500 focus:ring-opacity-80 active:bg-white active:border-white active:shadow-none"
    >
    <x-filament::icon icon="heroicon-s-home" class="size-5" />
</a>
</div>