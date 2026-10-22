<x-filament-panels::page>
    <article
        class="payment-invoice mx-auto w-full max-w-4xl bg-white p-8 text-gray-950 shadow-sm print:max-w-none print:p-0 print:shadow-none">
        <div dir="rtl" class="mb-6 text-center text-sm font-semibold leading-7">
            <p>جمهورية السودان</p>
            <p>جامعة العلوم الصحية</p>
            <p>إدارة الشؤون المالية والإدارية</p>
            <p>الحسابات</p>
        </div>
        <header class="mb-8 flex items-start justify-between gap-6 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-2xl font-bold">إيصال دفع مالي</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('backend.ref_number') }}: {{ $record->ref_number }}</p>
            </div>
            <img class="max-h-20 max-w-48 object-contain" src="{{ asset('static/invoice_logo.png') }}"
                alt="{{ getCompanyName() }}">
        </header>

        <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.student') }}</dt>
                <dd class="mt-1 font-semibold">
                    {{ $record->charge?->student?->name ?? ($record->student?->name ?? '-') }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.college') }}</dt>
                <dd class="mt-1">{{ $record->college?->name ?? ($record->invoice?->college?->name ?? '-') }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.level') }}</dt>
                <dd class="mt-1">{{ $record->level?->name ?? ($record->invoice?->level?->name ?? '-') }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.amount') }}</dt>
                <dd class="mt-1 text-lg font-bold">
                    {{ number_format((float) $record->amount, 2) }}
                    {{ $record->currency?->symbol ?? $record->charge?->currency?->symbol }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.fee_type') }}</dt>
                <dd class="mt-1 text-lg font-bold">
                    {{ $record?->charge?->feeType?->name }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.created_at') }}</dt>
                <dd class="mt-1">
                    {{ $record->payment_date?->format('Y-m-d') ?? ($record->created_at?->format('Y-m-d') ?? '-') }}
                </dd>
            </div>
            @if ($record?->bank != null)
                <div>
                    <dt class="text-sm text-gray-600">{{ __('backend.bank') }}</dt>
                    <dd class="mt-1">{{ $record?->bank?->name ?? '-' }}</dd>
                </div>
            @endif

            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.status') }}</dt>
                <dd class="mt-1">
                    {{ \Packages\University\Enums\PaymentShortStatusEnum::tryFrom($record->status)?->getLabel() ?? $record->status }}
                </dd>
            </div>
            @if ($record->notes)
                <div class="sm:col-span-2">
                    <dt class="text-sm text-gray-600">{{ __('backend.notes') }}</dt>
                    <dd class="mt-1 whitespace-pre-line">{{ $record->notes }}</dd>
                </div>
            @endif
        </dl>

        <div dir="rtl" class="mt-12 grid grid-cols-2 gap-8 text-sm">
            <div>
                <div class="h-10 border-b border-gray-500"></div>
                <p class="mt-2 text-right text-black">اسم المتحصل : {{ $record?->user?->name }}</p>
            </div>
            <div>
                <div class="h-10 border-b border-gray-500"></div>
                <p class="mt-2 text-left">التوقيع</p>
            </div>
        </div>

        <footer class="mt-12 border-t border-gray-200 pt-5 text-center text-sm text-gray-600">
            {{ getCompanyName() }}
        </footer>
    </article>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 1.5cm;
            }

            body * {
                visibility: hidden;
            }

            .payment-invoice,
            .payment-invoice * {
                visibility: visible;
            }

            .payment-invoice {
                position: absolute;
                inset: 0;
                width: 100%;
            }
        }
    </style>
</x-filament-panels::page>
