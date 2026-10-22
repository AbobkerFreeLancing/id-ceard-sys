<x-filament-panels::page class="padd-zero">
    <div>
        {{-- -------------- --}}
        <!-- component -->
        <div class="mx-auto py-4 bg-white print-this">
            <article class="overflow-hidden">
                <div class="bg-[white] rounded-b-md">
                    <div class="p-9 py-2">
                        <div class="text-black">
                            <p class="mb-8 print-only">
                                <img class="object-cover invoice-logo"
                                    src="{{ asset('static/client/invoice_logo.png')}}" />
                            </p>

                            <h3 class="text-2xl font-extrabold mb-4 font-body">{{ __('backend.balance_transfer') }}</h3>

                            <table class="bordered mb-4 min-w-full align-middle whitespace-nowrap">
                                <thead>
                                    <tr class="border-b border-gray-400 bg-gray-200">
                                        <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.transfer_from')) }}
                                        </th>
                                        <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.transfer_to')) }}
                                        </th>
                                        <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.amount')) }}</th>
                                        <th class="p-1 font-bold text-start">{{ ucfirst(__('backend.created_at')) }}
                                        </th>
                                    </tr>
                                </thead>
                                <!-- END Table Header -->

                                <!-- Table Body -->
                                <tbody>
                                    <tr class="border-b border-gray-100">
                                        <td class="px-1">{{ $record->from->name_currency }}</td>
                                        <td class="px-1">{{ $record->to->name_currency }}</td>
                                        <td class="px-1"><strong>{{ number_format($record->amount, 2) }}</strong>
                                            {{ $record->from->currency->symbol }}</td>
                                        <td class="px-1">{{ $record->created_at }}</td>
                                    </tr>
                                </tbody>
                                <!-- END Table Body -->
                            </table>

                            <p class="mt-8 border border-gray-200 p-1 bg-gray-50">
                                {{ __('backend.exchange_rate') }}:
                                {{ $record->from->currency->name }} =
                                {{ $record->acc_from_exchange_rate < 1 ? $record->acc_from_exchange_rate : number_format($record->acc_from_exchange_rate, 2) }}
                                {{ $record->to->currency->name }}
                            </p>
                            <p class="mt-2 border border-gray-200 p-1 bg-gray-50">
                                {{ $record->to->currency->name }} =
                                {{ $record->acc_to_exchange_rate < 1 ? $record->acc_to_exchange_rate : number_format($record->acc_to_exchange_rate, 2) }}
                                {{ $record->from->currency->name }}
                            </p>

                            @if ($record->description)
                                <p class="text-xl mt-4">{{ __('backend.statement') }}: {{ $record->description }}</p>
                            @endif


                        </div>
                    </div>
                </div>
            </article>

            <article class="invoice-tagline text-center py-4 mt-8">
                <p class="mb-2 font-bold">{{ getCompanyName() }}</p>
                <p class="font-bold">&copy; {{ date('Y') }}</p>
            </article>

        </div>
        {{-- -------------- --}}
    </div>

    <style>
        @media print {
            body {
                box-sizing: content-box;
            }

            body * {
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
