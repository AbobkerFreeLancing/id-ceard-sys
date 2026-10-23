<div class="flex justify-end px-0">
    @php
        use Filament\Facades\Filament;

        // ACC
        use App\Filament\Resources\Accounting\Safes\SafeResource;
        use App\Filament\Resources\Accounting\Expenses\ExpenseResource;
        use App\Filament\Resources\Accounting\AccountBalanceTransferResource;
        // Common
        use App\Filament\Resources\Common\Users\UserResource;
        use App\Filament\Resources\Common\Customers\CustomerResource;

    @endphp
    <!-- Dropdown Container -->
    <div x-data="{ open: false }" class="relative inline-block">
        <!-- Dropdown Toggle Button -->
        <button type="button"
            class="inline-flex justify-center items-center gap-x-1 border font-semibold focus:outline-none px-3 py-1 text-sm rounded-xl border-gray-200 bg-white text-gray-800 shadow-sm hover:text-gray-800 hover:border-gray-300 hover:shadow focus:ring-1 focus:ring-primary-500 focus:ring-opacity-80 active:bg-white active:border-white active:shadow-none dark:bg-gray-700 dark:text-gray-50 dark:hover:text-white"
            id="tk-dropdown-with-header-badges" aria-haspopup="true" x-bind:aria-expanded="open" x-on:click="open = true">
            <x-tabler-plus class="inline-block size-4 text-primary-500" />
            <span class="capitalize">{{ __('backend.action_add') }}</span>
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
            class="absolute -end-4 origin-top-start mt-2 w-52 md:w-[380px] shadow-xl rounded z-1">
            <div class="bg-white shadow rounded divide-y divide-gray-100">

                <div class="p-2 lg:grid grid-cols-2 gap-y-1">


                    @if (auth()->user()->can('safes_management') && config('bedaya.accounting_enabled'))
                        <a role="menuitem"
                            href="{{ SafeResource::getUrl('create', ['tenant' => Filament::getTenant()]) }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-building-bank class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.safe_and_bank_account') }}</span>
                            </div>
                        </a>
                    @endif
                    @if (auth()->user()->can('account_balance_transfer') && config('bedaya.accounting_enabled'))
                        <a role="menuitem"
                            href="{{ AccountBalanceTransferResource::getUrl('create', ['tenant' => Filament::getTenant()]) }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-transfer class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.balance_transfer') }}</span>
                            </div>
                        </a>
                    @endif
                    @if (auth()->user()->can('expense_management') && config('bedaya.accounting_enabled'))
                        <a role="menuitem"
                            href="{{ ExpenseResource::getUrl('create', ['tenant' => Filament::getTenant()]) }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-code-minus class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.expense') }}</span>
                            </div>
                        </a>
                    @endif

                    @if (auth()->user()->can('receipt_vouchers_management') &&
                            config('bedaya.accounting_enabled') &&
                            config('bedaya.receipt_vouchers_enabled'))
                        <a role="menuitem"
                            href="{{ route('filament.admin.resources.accounting.receipt-vouchers.create') }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-code-plus class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.receipt_voucher') }}</span>
                            </div>
                        </a>
                    @endif

                    @if (config('bedaya.system_customers_enabled') && auth()->user()->can('customer_management'))
                        <a role="menuitem"
                            href="{{ CustomerResource::getUrl('create', ['tenant' => Filament::getTenant()]) }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-user class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.customer') }}</span>
                            </div>
                        </a>
                    @endif



                    @if (auth()->user()->can('user_management'))
                        <a role="menuitem"
                            href="{{ UserResource::getUrl('create', ['tenant' => Filament::getTenant()]) }}"
                            class="quick-add-link">
                            <div class="flex-none flex items-center gap-x-2">
                                <x-tabler-user-plus class="inline-block size-5 text-primary-500" />
                                <span>{{ __('backend.user') }}</span>
                            </div>
                        </a>
                    @endif


                </div>

            </div>
        </div>
    </div>
    <!-- END Dropdown Container -->
</div>
