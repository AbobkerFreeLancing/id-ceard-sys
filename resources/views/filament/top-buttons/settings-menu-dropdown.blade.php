<div class="flex justify-end px-0">
    @php
        use App\Filament\Resources\Common\Settings\SettingResource;
        use App\Filament\Resources\Accounting\BankResource;
        use App\Filament\Resources\Common\Branches\BranchResource;
    @endphp
    <!-- Dropdown Container -->
    <div x-data="{ open: false }" class="relative inline-block">
        <!-- Dropdown Toggle Button -->
        <button type="button"
            class="inline-flex justify-center items-center gap-x-1 border font-semibold focus:outline-none px-2 py-1 text-sm rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm hover:text-gray-800 hover:border-gray-300 hover:shadow focus:ring-1 focus:ring-primary-500 focus:ring-opacity-80 active:bg-white active:border-white active:shadow-none"
            id="tk-dropdown-with-header-badges" aria-haspopup="true" x-bind:aria-expanded="open" x-on:click="open = true">
            <x-tabler-settings-2 class="inline-block size-4 text-primary-500" />
            <span>{{ __('backend.settings') }}</span>
        </button>
        <!-- END Dropdown Toggle Button -->

        <!-- Dropdown -->
        <div x-show="open" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="transform opacity-0 scale-75"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-75" x-on:click.outside="open = false" role="menu"
            aria-labelledby="tk-dropdown-with-header-badges"
            class="absolute -end-4 origin-top-start mt-2 w-52 shadow-xl rounded z-1">
            <div class="bg-white shadow rounded divide-y divide-gray-100">

                <div class="p-2 gap-y-1">
                    @if (auth()->user()->can('settings_management'))
                        <a role="menuitem" href="{{ SettingResource::getUrl('index') }}" class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-settings class="inline-block size-5 opacity-50" />
                                <span>{{ __('backend.global_settings') }}</span>
                            </div>
                        </a>
                    @endif
                    @if (auth()->user()->can('bank_management'))
                        <a role="menuitem" href="{{ BankResource::getUrl('index') }}" class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-building-bank class="inline-block size-5 opacity-50" />
                                <span>{{ __('backend.banks') }}</span>
                            </div>
                        </a>
                    @endif
                    @if (config('bedaya.has_multi_branch'))
                        <a role="menuitem" href="{{ BranchResource::getUrl('index') }}" class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-git-branch class="inline-block size-5 opacity-50" />
                                <span>{{ __('backend.branches') }}</span>
                            </div>
                        </a>
                    @endif
                    {{-- Manufacturing --}}
                    @if (config('bedaya.manufacturing_enabled'))
                        <a role="menuitem" href="{{ ManufacturingOrderStatusResource::getUrl('index') }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-git-branch class="inline-block size-5 opacity-50" />
                                <span>{{ __('backend.manufacturing_order_statuses') }}</span>
                            </div>
                        </a>
                        <a role="menuitem" href="{{ ProductionPlanStatusResource::getUrl('index') }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-bolt class="inline-block size-5 opacity-50" />
                                <span>{{ __('backend.production_plan_statuses') }}</span>
                            </div>
                        </a>
                    @endif
                    {{-- <hr class="col-span-2 w-full border-gray-200 border-dashed my-1"> --}}
                    {{-- Schools --}}

                    {{-- End Schools --}}
                </div>

            </div>
        </div>
    </div>
    <!-- END Dropdown Container -->
</div>
