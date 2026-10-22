<x-filament-panels::page>
    <main class="id-card-print-root flex justify-center px-4 py-8">
        <article
            class="student-id-card relative flex aspect-[85.6/54] w-full max-w-[560px] flex-col overflow-hidden rounded-[18px] border border-slate-200 bg-white font-sans text-slate-800 shadow-xl">
            <header
                class="relative flex min-h-[25%] items-center gap-3 overflow-hidden bg-gradient-to-r from-[#102c50] to-[#155e75] px-[5%] py-3 text-white">
                <img class="relative z-10 h-auto max-h-12 w-[12%] rounded bg-white object-contain p-1"
                    src="{{ dev()?->admin_logo_url ?? asset('static/logo.png') }}"
                    alt="{{ getCompanyName() ?? config('app.name') }}">
                <div class="relative z-10 min-w-0">
                    <p class="m-0 truncate text-[clamp(12px,2.7vw,18px)] font-bold">
                        {{ getCompanyName() ?? config('app.name') }}
                    </p>
                    <p class="mb-0 mt-1 text-[clamp(9px,1.8vw,12px)] uppercase tracking-[.12em] text-cyan-100">
                        {{ __('backend.university_id_card') }}
                    </p>
                </div>
                <span
                    class="absolute -right-5 -top-[55px] h-[155px] w-[155px] rounded-full border border-white/15 shadow-[0_0_0_18px_rgb(255_255_255_/_5%),0_0_0_38px_rgb(255_255_255_/_4%)]"
                    aria-hidden="true"></span>
            </header>

            <section class="flex flex-1 items-center justify-between gap-3 px-[5%] py-[3%]">
                <div class="flex min-w-0 flex-1 flex-col justify-center gap-2">
                    <p
                        class="mb-0.5 text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">
                        {{ __('backend.student') }}
                    </p>
                    <h1 class="mb-2 truncate text-[clamp(15px,3.4vw,22px)] font-bold leading-tight text-[#102c50]">
                        {{ $record->student?->name ?? '—' }}
                    </h1>

                    <div class="mb-2 grid grid-cols-[1.35fr_1fr] gap-3">
                        <div class="min-w-0">
                            <span
                                class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.college') }}</span>
                            <strong
                                class="block truncate text-[clamp(9px,1.7vw,12px)] font-semibold text-slate-700">{{ $record->college?->name ?? '—' }}</strong>
                        </div>
                        <div class="min-w-0">
                            <span
                                class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.level') }}</span>
                            <strong
                                class="block truncate text-[clamp(9px,1.7vw,12px)] font-semibold text-slate-700">{{ $record->level?->name ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="mb-2 grid grid-cols-[1.35fr_1fr] gap-3">
                        <div class="min-w-0">
                            <span
                                class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.university_no') }}</span>
                            <strong style="letter-spacing:2px"
                                class="block truncate text-[clamp(9px,1.7vw,12px)] font-semibold text-slate-700">{{ $record->student->university_no }}</strong>
                        </div>
                        {{-- <div class="min-w-0">
                            <span class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.level') }}</span>
                            <strong class="block truncate text-[clamp(9px,1.7vw,12px)] font-semibold text-slate-700">{{ $record->level?->name ?? '—' }}</strong>
                        </div> --}}
                    </div>

                    <div class="grid grid-cols-[1.35fr_1fr] gap-2.5">
                        <div class="min-w-0">
                            <span
                                class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.issue_date') }}</span>
                            <strong
                                class="block truncate text-[clamp(9px,1.7vw,12px)] bidi text-right rtl font-semibold text-slate-700">{{ $record->issue_date?->format('d M Y') ?? '—' }}</strong>
                        </div>
                        <div class="min-w-0">
                            <span
                                class="mb-0.5 block text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">{{ __('backend.expire_date') }}</span>
                            <strong
                                class="block truncate text-[clamp(9px,1.7vw,12px)] font-semibold text-slate-700 bidi text-right rtl">{{ $record->expiry_date?->format('d M Y') ?? '—' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    <img class="h-[clamp(68px,16vw,92px)] w-[clamp(54px,13vw,72px)] rounded-lg border border-slate-200 bg-slate-100 object-cover shadow-sm"
                        src="{{ $record->student?->ProfilePictureUrl }}"
                        alt="{{ $record->student?->name ?? __('backend.student') }}">
                    <div class="flex w-[clamp(54px,13vw,76px)] flex-col items-center text-center">
                        <img class="mb-1 block aspect-square w-full [image-rendering:pixelated]"
                            src="{{ $this->getQrCodeDataUri() }}"
                            alt="{{ __('backend.card_number') }} {{ $record->ref_number }}">
                        <span
                            class="text-[clamp(8px,1.5vw,10px)] font-semibold uppercase tracking-wider text-slate-500">
                            {{ __('backend.card_number') }}
                        </span>
                        <strong class="max-w-full truncate text-[clamp(8px,1.5vw,10px)] text-slate-700">
                            {{ $record->ref_number ?? '—' }}
                        </strong>
                    </div>
                </div>
            </section>

            <footer class="h-[5px] bg-gradient-to-r from-teal-500 via-teal-300 to-amber-300"></footer>
        </article>
    </main>

    <style>
        @media print {
            @page {
                size: 90mm 50mm;
                margin: 0;
            }

            body * {
                visibility: hidden !important;
            }

            .id-card-print-root,
            .id-card-print-root * {
                visibility: visible !important;
            }

            .id-card-print-root {
                position: absolute;
                inset: 0;
                display: block;
                width: 85mm;
                height: 45mm;
                padding: 0;
            }

            .student-id-card {
                width: 85mm;
                height: 45mm;
                max-width: none;
                aspect-ratio: auto;
                border: 0;
                border-radius: 0;
                box-shadow: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</x-filament-panels::page>
