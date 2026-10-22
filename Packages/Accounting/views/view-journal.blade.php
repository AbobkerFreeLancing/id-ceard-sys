<x-filament-panels::page>
<div>
{{-- -------------- --}}
 <div class="mx-auto py-4 bg-white print-this">
  <article class="overflow-hidden">
   <div class="bg-[white] rounded-b-md">
    <div class="p-4 py-2">
     <div class="text-black">
      <p class="mb-8 print-only">
        <img class="object-cover invoice-logo"
        src="{{ asset('static/client/invoice_logo.png') }}" />
    </p>

        <div class="flex items-center justify-between">
            <h3 class="font-body">
                <p class="text-lg lg:text-2xl font-extrabold">{{ __('backend.journal') }}: <span class="ltr bidi">#{{$record->ref_number}}</span></p>
            </h3>
            <p class=""><strong>{{ __('backend.print_date') }}:</strong> ({{ now() }})</p>
        </div>
     </div>
     <p class="text-lg my-2"><strong>{{ __('backend.journal_date') }}</strong> : {{ $record->the_date }}</p>
     @if ($record->statement)
     <p class="text-lg my-4"><strong>{{ __('backend.statement') }}</strong> : {{ $record->statement }}</p>
     @endif
    </div>

    {{-- ----------------------------- --}}
    <div class="p-4 py-1 my-4">
    <div class="border-gray-400 rounded min-w-full bg-white">
    <table class="bordered min-w-full align-middle whitespace-nowrap">
        <thead>
        <tr class="border-b border-gray-400 bg-gray-200">
            <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.account')) }}</th>
            <th class="p-1 font-bold text-center">{{ ucfirst(__('backend.debit')) }}</th>
            <th class="p-1 font-bold text-center">{{ ucfirst(__('backend.credit')) }}</th>
            <th class="p-1 font-bold text-center">{{ ucfirst(__('backend.statement')) }}</th>
        </tr>
        </thead>
        <!-- END Table Header -->

        <!-- Table Body -->
        <tbody>
        @foreach ($record->entries as $entry)
        <tr class="border-b border-gray-100">
            <td class="px-1">{{ $entry?->account?->name }}</td>
            <td class="text-lg font-bold px-1 text-center">{{ number_format($entry->debit,2) }}</td>
            <td class="text-lg font-bold px-1 text-center">{{ number_format($entry->credit,2) }}</td>
            <td class="px-1">{{ $entry?->statement }}</td>
            </tr>
        @endforeach
        </tbody>
        <!-- END Table Body -->
    </table>
</div>
    {{-- ----------  --}}
    <article class="invoice-footer hidden">
        <p class="my-1 border border-gray-200 font-bold p-1 bg-gray-50">
            <strong>{{ __('backend.total') }}</strong>: {{ number_format($record->total,2) }} &nbsp;/&nbsp;
        </p>

      </article>
    {{-- ----------  --}}

    <footer class="invoice-tagline text-center py-4 mt-4">
          <p class="mt-2">{{ getInvoiceTagline() }}</p>
          <p class="mb-2 font-bold">{{ getCompanyName() }}</p>
          <p class="font-bold">&copy; {{ date('Y') }}</p>
    </footer>

    </div>
    {{-- ----------------------------- --}}
   </div>
  </article>
 </div>
{{-- -------------- --}}

</div>


@push('scripts')
    <script>
        let searchKeys = window.location.search;

        let UrlPrms = new URLSearchParams(searchKeys);

        let printx = UrlPrms.get('print_auto');

        window.addEventListener('livewire:load', function(e) {
            if(printx == 1) {
                window.print();
            }
        })
    </script>
@endpush

</x-filament-panels::page>
