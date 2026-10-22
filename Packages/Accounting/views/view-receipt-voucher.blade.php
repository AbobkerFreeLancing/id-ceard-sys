<x-filament-panels::page>
<div>
{{-- -------------- --}}
<!-- component -->
 <div class="mx-auto py-4 bg-white print-this">
  <article class="overflow-hidden">
   <div class="bg-[white] rounded-b-md">
    <div class="p-4 py-2">
     <div class="text-black">

        <p class="mb-8 print-only">
        <img class="object-cover invoice-logo"
        src="{{ asset('static/client/invoice_logo.png') }}" />
    </p>
      {{-- ------------------ --}}
      <article class="flex justify-between">
        <h3 class="text-3xl font-extrabold font-body">
          {{ Str::ucfirst(__('backend.receipt_voucher')) }}
          <p class="my-2 text-xl"><span>{{ __('backend.date') }}</span>: <strong>{{ $record->receipt_date }}</strong></p>
        </h3>

        <p class="text-xl">{{ __('backend.print_date_time') }} <br> (<span class="bidi ltr">{{ now() }}</span>)</p>
      </article>

      @if ($record->giver_name != '')
      <h2 class="text-xl mb-8">{{ __('backend.name') }}: {{ $record->giver_name }}</h2>
      @endif

      {{-- ------------------ --}}
      <p class="my-2 text-xl"><span>{{ __('backend.amount') }}</span>: <strong>{{ number_format($record->amount,0) }}</strong> ({{ $record?->currency?->symbol }})</p>
      <br>
      <p class="my-2 text-lg"><span>{{ __('backend.receiver_name') }}</span>: <strong>{{ $record->receiver_name }}</strong></p>
      <p class="text-lg"><strong>{{ __('backend.statement') }}</strong>: {{ $record->notes }}</p>
      <br><br>
     </div>
    </div>

    <div class="p-4 py-8">
     <div class="flex mb-8 justify-start w-full">
        <p class="font-bold">{{ __('backend.signature') }}: <span class="font-normal">______________________</span></p>
     </div>
     <div class="flex justify-start w-full">
        <p class="font-bold">{{ __('backend.stamp') }}: <span class="font-normal">______________________</span></p>
     </div>
    </div>

    <article class="invoice-tagline text-center py-8">
        <hr class="my-4">
          <p class="text-xl my-2 font-bold">{{ getCompanyName() }}</p>
          <p class="text-xl font-bold">{{ date('Y') }}</p>
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
    margin: 1.2cm !important;
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