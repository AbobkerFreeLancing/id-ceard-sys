<x-filament-panels::page>
<div>
{{-- -------------- --}}
<!-- component -->
 <div class="mx-auto py-4 bg-white print-this">
  <article class="overflow-hidden">
   <div class="bg-[white] rounded-b-md">
    <div class="p-4 py-2">
     <div class="text-slate-700">

      <p class="mb-8 print-only">
        <img class="object-cover invoice-logo"
        src="{{ asset('static/client/invoice_logo.png') }}" />
    </p>

      <article class="flex justify-between">
        <h3 class="text-2xl font-bold font-body">
          {{ Str::ucfirst(__('backend.payment_voucher')) }} : {{ $record->account->name }}
        </h3>
        <p class="text-lg">{{ __('backend.print_date') }} <br> (<span class="bidi ltr">{{ now() }}</span>)</p>
      </article>

      <p class="my-2"><strong>{{ __('backend.date') }}</strong>: {{ $record->expense_date }}</p>
      <p class="my-2"><strong>{{ __('backend.amount') }}</strong>: {{ number_format($record->amount,2) }}
        ({{ $record->amount_x }}) ({{ $record?->currency?->symbol }})</p>
      <p class="my-2"><strong>{{ __('backend.receiver_name') }}</strong>: {{ $record->receiver_name }}</p>
     </div>
    </div>

    @if ($record->notes != '')
    <div class="p-4 py-2">
        <div class="flex w-full">
            <p>{{ __('backend.statement') }} : {{ $record->notes }}</p>
        </div>
    </div>
    @endif

    @if (count($record->items) > 0)
    <div class="p-4 py-2">
        <table class="bordered min-w-full align-middle whitespace-nowrap">
        <thead>
        <tr class="border-b border-gray-400 bg-gray-200">
            <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.the_itemx')) }}</th>
            <th class="p-1 font-bold text-center">{{ ucfirst(__('backend.qty')) }}</th>
            <th class="p-1 font-bold text-center">{{ ucfirst(__('backend.price')) }}</th>
        </tr>
        </thead>
        <!-- END Table Header -->

        <!-- Table Body -->
        <tbody>
        @foreach ($record->items as $item)
        <tr class="">
            <td class="p-1"><p class="font-medium">{{ $item->name }}</p></td>
            <td class="p-1 text-lg font-bold text-center">{{ $item->qty }}</td>
            <td class="p-1 text-lg font-bold text-center">{{ number_format($item->price,2) }}</td>
        </tr>
        @endforeach
        </tbody>
        <!-- END Table Body -->
    </table>
    </div>
    @endif

    <article class="invoice-tagline text-center py-8">
        <hr class="my-4">
          <p class="text-lg my-2 font-bold">{{ getCompanyName() }}</p>
          <p class="text-lg font-bold">{{ date('Y') }}</p>
    </article>

   </div>
  </article>
 </div>
{{-- -------------- --}}
</div>

<style>
    @media print {
    body {
    box-sizing: content-box;
    }

body  *{
    font-size: 16pt !important
}

@page {
    /* a4 */
    margin: 1.5cm !important;
    size: 8.3in 11.7in !important;
}
    }
</style>
</x-filament-panels::page>

@push('scripts')
    <script>
        Livewire.on('print', () => {
            window.print()
        })
    </script>
@endpush