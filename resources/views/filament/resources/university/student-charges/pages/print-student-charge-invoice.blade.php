<x-filament-panels::page>
    <article
        class="charge-invoice mx-auto w-full max-w-4xl bg-white p-8 text-gray-950 shadow-sm print:max-w-none print:p-0 print:shadow-none">
        <div dir="rtl" class="mb-6 text-center text-sm font-semibold leading-7">
            <p>جمهورية السودان</p>
            <p>جامعة العلوم الصحية</p>
            <p>إدارة الشؤون المالية والإدارية</p>
            <p>الحسابات</p>
        </div>

        <header class="mb-8 flex items-start justify-between gap-6 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ __('backend.student_charge_invoice') }}</h1>
                <p class="mt-2 text-sm text-black">{{ __('backend.ref_number') }}: {{ $record->ref_number }}</p>
            </div>
            <img class="max-h-20 max-w-48 object-contain" src="{{ asset('static/invoice_logo.png') }}"
                alt="{{ getCompanyName() }}">
        </header>

        <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.student') }}</dt>
                <dd class="mt-1 font-semibold">{{ $record->student?->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.fee_type') }}</dt>
                <dd class="mt-1">{{ $record->feeType?->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.college') }}</dt>
                <dd class="mt-1">{{ $record->feeStructure?->college?->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.level') }}</dt>
                <dd class="mt-1">{{ $record->feeStructure?->level?->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.academic_year') }}</dt>
                <dd class="mt-1">{{ $record->academicYear?->name ?? '-' }}</dd>
            </div>
            
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.net_amount') }}</dt>
                <dd class="mt-1 text-lg font-bold">{{ number_format((float) $record->net_amount, 2) }}
                    {{ $record->currency?->symbol }}</dd>
            </div>
            
            <div>
                <dt class="text-sm text-gray-600">{{ __('backend.due_date') }}</dt>
                <dd class="mt-1">
                    {{ $record->created_at->format('d-m-Y') }}
                </dd>
            </div>
            
            @if ($record->description)
                <div class="sm:col-span-2">
                    <dt class="text-sm text-gray-600">{{ __('backend.description') }}</dt>
                    <dd class="mt-1 whitespace-pre-line">{{ $record->description }}</dd>
                </div>
            @endif
        </dl>

        <div dir="rtl" class="mt-12 grid grid-cols-2 gap-8 text-sm">
            
            
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

            .charge-invoice,
            .charge-invoice * {
                visibility: visible;
            }

            .charge-invoice {
                position: absolute;
                inset: 0;
                width: 100%;
            }
        }
    </style>
</x-filament-panels::page>
