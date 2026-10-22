<x-filament-panels::page>

    <main class="selected-payments-print mx-auto w-full max-w-5xl bg-white p-6 text-gray-950 shadow-sm">

        <div dir="rtl" class="mb-5 text-center text-sm font-semibold leading-6">
            <p>جمهورية السودان</p>
            <p>جامعة العلوم الصحية</p>
            <p>إدارة الشؤون المالية والإدارية</p>
            <p>الحسابات</p>
        </div>
        <header class="mb-4 flex items-center justify-between gap-4 border-b border-gray-300 pb-3">
            <div class="flex items-center gap-4">
                <img class="max-h-14 max-w-28 object-contain"
                    src="{{ dev()?->invoice_logo_url ?? asset('static/invoice_logo.png') }}"
                    alt="{{ getCompanyName() ?? config('app.name') }}">
                <h1 class="text-xl font-bold">إيصالات الدفع</h1>
            </div>
            <p class="text-right text-sm font-semibold">{{ now()->format('d-m-Y') }}</p>
        </header>

        <table class="w-full table-fixed border-collapse text-right text-xs">
            <thead>
                <tr class="bg-slate-100">
                    <th class="w-[16%] border border-slate-300 px-2 py-2">{{ __('backend.ref_number') }}</th>

                    <th class="w-[25%] border border-slate-300 px-2 py-2">{{ __('backend.student') }}</th>
                    <th class="w-[20%] border border-slate-300 px-2 py-2">{{ __('backend.fee_type') }}</th>
                    <th class="w-[24%] border border-slate-300 px-2 py-2">{{ __('backend.amount') }}</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td class="break-words border border-slate-300 px-2 py-2">{{ $payment->ref_number }}</td>

                        <td class="break-words border border-slate-300 px-2 py-2">
                            {{ $payment->charge?->student?->name ?? ($payment->student?->name ?? '—') }}
                        </td>
                        <td class="break-words border border-slate-300 px-2 py-2">
                            {{ $payment->charge?->feeType?->name ?? '—' }}
                        </td>
                        <td class="border border-slate-300 px-2 py-2 font-semibold">
                            {{ number_format((float) $payment->amount, 2) }}
                            {{ $payment->currency?->symbol ?? $payment->charge?->currency?->symbol }}
                            <br>
                            {{ Packages\University\Enums\PaymentShortStatusEnum::tryFrom($payment->status)->getLabel() }}
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <footer class="mt-4 border-t border-gray-300 pt-3 text-sm text-gray-900">
            {{ __('backend.total') }}:
            @foreach ($payments->groupBy(fn($payment) => $payment->currency?->symbol ?? ($payment->charge?->currency?->symbol ?? '')) as $currency => $currencyPayments)
                <span class="ml-2 font-semibold text-black">
                    {{ number_format((float) $currencyPayments->sum('amount'), 2) }} {{ $currency }}
                </span>
            @endforeach
        </footer>
    </main>

    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body * {
                visibility: hidden !important;
            }

            .selected-payments-print,
            .selected-payments-print * {
                visibility: visible !important;
            }

            .selected-payments-print {
                position: absolute;
                inset: 0;
                width: 100%;
                max-width: none;
                padding: 0;
                box-shadow: none;
                font-size: 8pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .selected-payments-print table {
                font-size: 7pt;
            }

            .selected-payments-print th,
            .selected-payments-print td {
                padding: 3px 5px;
            }

            .selected-payments-print tr {
                break-inside: avoid;
            }
        }
    </style>
</x-filament-panels::page>
