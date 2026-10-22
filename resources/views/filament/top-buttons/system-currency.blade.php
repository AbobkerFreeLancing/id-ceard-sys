@php
  $curr = App\Models\Setting::find(1)->currency->symbol;
  $curr_url = App\Filament\Resources\Accounting\CurrencyResource::getUrl('index');
@endphp
<a href="{{ $curr_url }}" class="inline-flex justify-center items-center gap-x-2 border font-semibold focus:outline-none px-3 py-1 
text-sm rounded-full border-gray-300 bg-white text-gray-800 shadow-sm hover:text-gray-800 hover:border-gray-300 hover:shadow
focus:ring-1 focus:ring-primary-500 focus:ring-opacity-80 active:bg-white active:border-white active:shadow-none">
  <span>{{ $curr }}</span>
</a>