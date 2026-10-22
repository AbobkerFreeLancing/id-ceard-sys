<div class="flex flex-col items-center gap-4">
    {{-- Side Toggle Switch --}}
    <div class="inline-flex rounded-lg p-1 bg-gray-100 border border-gray-200 text-xs font-semibold">
        <button type="button" 
                wire:click="$set('currentSide', 'front')"
                class="px-4 py-1.5 rounded-md transition {{ $currentSide === 'front' ? 'bg-white shadow text-primary-700' : 'text-gray-600' }}">
            الوجه الأمامي (Front)
        </button>
        <button type="button" 
                wire:click="$set('currentSide', 'back')"
                class="px-4 py-1.5 rounded-md transition {{ $currentSide === 'back' ? 'bg-white shadow text-primary-700' : 'text-gray-600' }}">
            الوجه الخلفي (Back)
        </button>
    </div>

    {{-- Physical CR-80 Card Canvas (Proportional Scale: 85.6mm x 53.98mm ~ Ratio 1.586) --}}
    <div class="relative w-[340px] h-[214px] sm:w-[420px] sm:h-[265px] rounded-2xl shadow-xl overflow-hidden border border-gray-300 bg-white select-none transition-all duration-300">
        {{-- Card Background image if uploaded --}}
        @php
            $bg = $currentSide === 'front' ? $template?->front_background_image : $template?->back_background_image;
        @endphp
        @if($bg)
            <img src="{{ asset('storage/' . $bg) }}" alt="Background" class="absolute inset-0 w-full h-full object-cover pointer-events-none">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-blue-50"></div>
        @endif

        {{-- Dynamic Elements Layer --}}
        <div class="relative w-full h-full p-4 flex flex-col justify-between">
            @if($currentSide === 'front')
                {{-- Top Bar: Logo & Organization --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            ID
                        </div>
                        <span class="text-xs font-bold text-gray-800">
                            {{ $template?->organization?->name ?? 'المؤسسة الذكية للبطاقات' }}
                        </span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 font-semibold">
                        {{ $template?->card_type?->label() ?? 'بطاقة رسمية' }}
                    </span>
                </div>

                {{-- Center Area: Photo & Info --}}
                <div class="flex items-center gap-4 my-auto">
                    <img src="{{ $card?->cardholder?->photo_url ?? asset('frontend/img/placeholder_avatar.png') }}" 
                         alt="Photo" 
                         class="w-20 h-24 sm:w-24 sm:h-28 rounded-xl object-cover border-2 border-primary-500 shadow-sm shrink-0">
                    
                    <div class="space-y-1 text-start">
                        <div class="text-sm sm:text-base font-extrabold text-gray-900 leading-tight">
                            {{ $card?->cardholder?->full_name_ar ?? 'اسم حامل البطاقة الافتراضي' }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $card?->cardholder?->identifier_code ?? 'ID-2026-000001' }}
                        </div>
                        <div class="text-[11px] font-medium text-primary-700">
                            {{ $card?->cardholder?->department?->name ?? 'قسم تقنية المعلومات' }}
                        </div>
                    </div>
                </div>

                {{-- Bottom Bar: Security QR & Expiry --}}
                <div class="flex items-center justify-between text-[10px] text-gray-500 pt-1 border-t border-gray-100">
                    <span class="font-mono text-[9px]">{{ $card?->card_uid ?? 'CRD-XXXX-XXXX' }}</span>
                    <span>صالحة حتى: {{ $card?->expiry_date?->format('Y/m/d') ?? date('Y/12/31') }}</span>
                </div>
            @else
                {{-- Back Side --}}
                <div class="w-full h-full flex flex-col justify-between text-center text-xs text-gray-600 p-2">
                    <p class="text-[10px] leading-relaxed">
                        هذه البطاقة وثيقة رسمية صادرة عن المؤسسة. يجب إبرازها عند الطلب. عند العثور عليها يرجى تسليمها إلى مكتب شؤون البطاقات.
                    </p>

                    <div class="flex items-center justify-center gap-4 my-auto">
                        <div class="w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-[9px] text-gray-400">
                            [QR Code]
                        </div>
                        <div class="w-28 h-8 bg-gray-100 border border-gray-200 rounded flex items-center justify-center font-mono text-[10px] tracking-widest text-gray-400">
                            |||||||||||||||||
                        </div>
                    </div>

                    <p class="text-[9px] text-gray-400">
                        Huwia ID Smart Verification System &bull; https://huwia.local
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
