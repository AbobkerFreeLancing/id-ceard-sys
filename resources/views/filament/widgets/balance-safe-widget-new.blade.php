<x-filament-widgets::widget>
    <div class="relative w-full rounded-lg bg-white/40 ring-2 ring-zinc-200/50 backdrop-blur-lg">
        <!-- Header -->
        <div class="relative rounded-3xl bg-white/20">
            <div class="p-4">
                <div class="flex items-center gap-3">
                    <div
                        class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-700 to-primary-600 ring-2 ring-white/50">
                        <x-tabler-news class="inline-block size-6 text-white" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-800">{{ __('backend.safe_and_bank_accounts') }}</h2>
                        <p class="text-sm text-zinc-700">{{ __('backend.current_balance') }}</p>
                    </div>
                </div>
            </div>
            <!-- END Header -->

            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-4 py-2">
                @foreach ($data as $item)
                    <div class="relative rounded-lg bg-white p-2 px-4 shadow-sm border border-gray-200 shadow-zinc-100">
                        <div class="relative">
                            <p class="text-sm text-primary-500">{{ $item->name }}</p>
                            @if (auth()->user()->can('safe_balance_view'))
                                <p class="text-xl font-bold text-zinc-800">{{ number_format($item->balance, 2) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
