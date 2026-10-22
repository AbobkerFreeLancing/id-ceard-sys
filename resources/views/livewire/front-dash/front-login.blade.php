<div>
    <div id="page-container" class="hide-footer mx-auto flex min-w-80 flex-col bg-gray-50 p-4 py-8">
        <main id="page-content" class="flex max-w-full flex-auto flex-col">
            <div class="flex w-full">
                <div class="mx-auto flex w-full max-w-md grow flex-col bg-white rounded-lg shadow-sm p-4">
                    <header class="mb-4">
                        <h1 class="mb-2 text-xl font-extrabold">
                            {{ __('backend.login_to_your_account') }}
                        </h1>
                        <h2 class="text-sm font-normal text-gray-800">
                            <span class="font-normal">{{ __('backend.dont_have_an_account_yet') }}</span>
                            <a href="{{ route('front_register') }}"
                                class="font-medium text-primary-600 hover:text-primary-400">{{ __('backend.create_an_account') }}</a>
                        </h2>
                    </header>
                    <form wire:submit.prevent="login">
                        <div class="flex flex-col gap-5">
                            @error('invalid_login')
                                <p class="danger-error">{{ __('backend.invalid_login_details') }}</p>
                            @enderror
                            @error('email')
                                <p class="danger-error">{{ $message }}</p>
                            @enderror
                            
                            <div class="space-y-1">
                                <label for="email"
                                    class="inline-block text-sm font-medium">{{ __('backend.email') }}</label>
                                <input wire:model="email" type="email" id="email" name="email"
                                    class="block w-full rounded-lg border border-gray-200 px-3 py-2 leading-6 placeholder-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-500/50" />
                            </div>

                            @error('password')
                                <p class="danger-error">{{ $message }}</p>
                            @enderror

                            <div class="space-y-1" x-data="{ showPassword: false }">
                                <label for="password"
                                    class="inline-block text-sm font-medium">{{ __('backend.password') }}</label>
                                <div class="relative">
                                    <input wire:model="password" :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                        class="block w-full rounded-lg border border-gray-200 px-3 py-2 leading-6 placeholder-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-500/50" />
                                    
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 end-0 flex items-center pe-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        
                                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        
                                        <svg x-cloak style="display: none;" x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                            <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <a href="{{ route('front_reset_password') }}"
                                        class="inline-block text-sm font-medium text-primary-600 hover:text-primary-400">{{ __('backend.forgot_password') }}</a>
                                </div>
                            </div>
                            
                            <div>
                                <button type="submit" wire:loading.remove
                                    class="inline-flex cursor-pointer w-full items-center justify-center gap-2 rounded-lg border border-primary-700 bg-primary-700 px-6 py-3 leading-6 font-semibold text-white hover:border-primary-600 hover:bg-primary-600 hover:text-white focus:ring focus:ring-primary-400/50 active:border-primary-700 active:bg-primary-700">
                                    <span>{{ __('backend.login') }}</span>
                                </button>

                                <button wire:loading wire:loading.class="!flex"
                                    class="flex cursor-pointer w-full justify-center items-center gap-2 rounded-lg border border-gray-400 bg-gray-400 px-6 py-3 leading-6 font-semibold text-white hover:border-gray-500 hover:bg-gray-500 hover:text-white focus:ring focus:ring-gray-400/50 active:border-gray-400 active:bg-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="animate-spin icon icon-tabler icons-tabler-outline icon-tabler-loader-2">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3a9 9 0 1 0 9 9" />
                                    </svg>
                                    <span>{{ __('backend.processing') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
            </div>
        </main>
        </div>
</div>