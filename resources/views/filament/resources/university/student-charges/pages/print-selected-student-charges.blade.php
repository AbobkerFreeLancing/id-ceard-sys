<x-filament-panels::page>
    <main class="selected-charges-print mx-auto w-full max-w-5xl bg-white p-6 text-gray-950 shadow-sm">
        <div dir="rtl" class="mb-6 text-center text-sm font-semibold leading-7">
            <p>جمهورية السودان</p>
            <p>جامعة العلوم الصحية</p>
            <p>إدارة الشؤون المالية والإدارية</p>
            <p>الحسابات</p>
        </div>
        <header class="mb-5 flex items-center justify-between gap-4 border-b border-gray-300 pb-4">
            <div class="flex items-center gap-4">
                <img class="max-h-16 max-w-32 object-contain"
                    src="{{ dev()?->invoice_logo_url ?? asset('static/invoice_logo.png') }}"
                    alt="{{ getCompanyName() ?? config('app.name') }}">
                <div>
                    <h1 class="text-xl font-bold">{{ __('backend.student_charge_invoice') }}</h1>

                </div>
            </div>
            <p class="text-right text-sm font-semibold">{{ now()->format('d-m-Y') }}</p>
        </header>

        <table class="w-full table-fixed border-collapse text-right text-xs">
            <thead>
                <tr class="bg-slate-100">
                    {{-- <th class="w-[5%] border border-slate-300 px-2 py-2">#</th> --}}
                    <th class="w-[13%] border border-slate-300 px-2 py-2">{{ __('backend.ref_number') }}</th>
                    <th class="w-[15%] border border-slate-300 px-2 py-2 text-right">{{ __('backend.amount') }}</th>
                    <th class="w-[20%] border border-slate-300 px-2 py-2">{{ __('backend.student') }}</th>
                    <th class="w-[17%] border border-slate-300 px-2 py-2">{{ __('backend.fee_type') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($charges as $charge)
                    <tr>
                        {{-- <td class="border border-slate-300 px-2 py-2">{{ $loop->iteration }}</td> --}}
                        <td class="break-words border border-slate-300 px-2 py-2">{{ $charge->ref_number }}</td>
                        <td class="border border-slate-300 px-2 py-2 text-right font-semibold">
                            {{ number_format((float) $charge->net_amount, 2) }} {{ $charge->currency?->symbol }}
                        </td>
                        <td class="break-words border border-slate-300 px-2 py-2">{{ $charge->student?->name ?? '—' }}
                        </td>
                        <td class="break-words border border-slate-300 px-2 py-2">{{ $charge->feeType?->name ?? '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <footer class="mt-5 border-t border-gray-300 pt-3 text-base text-gray-900">
            {{ __('backend.total') }} :
            @foreach ($charges->groupBy(fn($charge) => $charge->currency?->symbol ?? '') as $currency => $currencyCharges)
                <span class="ml-2 font-semibold text-black">
                    {{ number_format((float) $currencyCharges->sum('net_amount'), 2) }} {{ $currency }}
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

            .selected-charges-print,
            .selected-charges-print * {
                visibility: visible !important;
            }

            .selected-charges-print {
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

            .selected-charges-print table {
                font-size: 7pt;
            }

            .selected-charges-print th,
            .selected-charges-print td {
                padding: 3px 5px;
            }

            .selected-charges-print tr {
                break-inside: avoid;
            }
        }
    </style>
</x-filament-panels::page>
