<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-100 text-primary-600 mb-4 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
            {{ __('idcard::idcard.scanner_title') }}
        </h1>
        <p class="mt-2 text-base text-gray-600 max-w-2xl mx-auto">
            {{ __('idcard::idcard.scanner_subtitle') }}
        </p>
    </div>

    {{-- Main Scanner Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        @if(!$hasChecked)
            <div class="space-y-6">
                {{-- Form Input --}}
                <form wire:submit.prevent="verify" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <input type="text"
                               wire:model="scannedCode"
                               placeholder="{{ __('idcard::idcard.enter_code_placeholder') }}"
                               autofocus
                               class="w-full ps-11 pe-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition font-mono text-sm">
                    </div>

                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="px-8 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-md transition disabled:opacity-50 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="verify">{{ __('idcard::idcard.btn_verify') }}</span>
                        <span wire:loading wire:target="verify" class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            جاري التحقق...
                        </span>
                    </button>
                </form>

                {{-- Interactive QR Camera helper reminder --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center text-sm text-gray-500">
                    💡 يمكنك توصيل قارئ باركود USB أو مسح البطاقة مباشرة عبر توجيه الكاميرا إلى هذا الحقل.
                </div>
            </div>
        @else
            {{-- Results Display --}}
            <div class="space-y-6">
                {{-- Status Banner --}}
                @if($status?->value === 'valid')
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-3 text-emerald-800">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-emerald-900">{{ $status->label() }}</h3>
                            <p class="text-sm text-emerald-700">تم التحقق من التوقيع الرقمي بنجاح، البطاقة معتمدة ومسجلة في النظام.</p>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-center gap-3 text-rose-800">
                        <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-rose-900">{{ $status?->label() ?? 'فشل التحقق' }}</h3>
                            <p class="text-sm text-rose-700">{{ $errorMessage ?? 'هذه البطاقة غير صالحة للاستخدام أو منتهية الصلاحية.' }}</p>
                        </div>
                    </div>
                @endif

                {{-- Cardholder Details if resolved --}}
                @if($resolvedCard && $resolvedCard->cardholder)
                    <div class="flex flex-col sm:flex-row gap-6 p-6 bg-gray-50 rounded-xl border border-gray-100 items-center sm:items-start">
                        <img src="{{ $resolvedCard->cardholder->photo_url }}" 
                             alt="Avatar" 
                             class="w-28 h-36 rounded-xl object-cover shadow-sm border-2 border-white shrink-0">

                        <div class="flex-grow space-y-3 text-center sm:text-start w-full">
                            <div>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">{{ __('idcard::idcard.cardholder_name') }}</span>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $resolvedCard->cardholder->full_name_ar }}</h2>
                                @if($resolvedCard->cardholder->full_name_en)
                                    <p class="text-sm text-gray-500">{{ $resolvedCard->cardholder->full_name_en }}</p>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-200 text-sm">
                                <div>
                                    <span class="text-xs text-gray-500 block">{{ __('idcard::idcard.identifier_code') }}</span>
                                    <span class="font-semibold text-gray-800">{{ $resolvedCard->cardholder->identifier_code }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">{{ __('idcard::idcard.department') }}</span>
                                    <span class="font-semibold text-gray-800">{{ $resolvedCard->cardholder->department?->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">{{ __('idcard::idcard.card_uid') }}</span>
                                    <span class="font-mono text-xs text-gray-700">{{ $resolvedCard->card_uid }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">{{ __('idcard::idcard.expiry_date') }}</span>
                                    <span class="font-semibold {{ $resolvedCard->isExpired() ? 'text-rose-600' : 'text-gray-800' }}">
                                        {{ $resolvedCard->expiry_date->format('Y-m-d') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Reset Button --}}
                <div class="flex justify-center pt-4">
                    <button type="button"
                            wire:click="resetScanner"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                        {{ __('idcard::idcard.btn_reset') }}
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
