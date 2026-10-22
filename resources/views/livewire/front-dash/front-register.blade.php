<div>
    <div id="page-container" class="mx-auto flex min-w-80 flex-col bg-gray-50 p-4">
        <!-- Page Content -->
        <main id="page-content" class="flex max-w-full flex-auto flex-col">
            <div class="flex w-full">
                <!-- Sign up Section -->
                    <div class="mx-auto flex w-full max-w-md grow flex-col bg-white rounded-lg shadow-sm p-4">
                        <!-- Header -->
                        <header class="mb-4">
                            <h1 class="mb-2 text-xl font-extrabold">{{ __('backend.create_an_account') }}</h1>
                            <h2 class="text-sm font-normal text-gray-800">
                                <span class="font-normal">{{ __('backend.already_have_an_account') }}</span>
                                <a href="{{ route('front_login') }}"
                                    class="font-medium text-primary-600 hover:text-primary-400">{{ __('backend.login2') }}</a>
                            </h2>
                        </header>
                        <!-- END Header -->

                        @if ($success)
                            <p class="bg-green-700 mb-2 rounded-lg mt-4 text-white px-2 py-2">
                                {{ __('backend.account_register_successfuly') }}
                            </p>
                        @endif

                        <!-- Sign up with email -->
                        <form wire:submit.prevent="register">
                            <div class="flex flex-col gap-5">
                                <div class="space-y-1">
                                    @error('name')
                                        <p class="danger-error">
                                            {{ $message }}</p>
                                    @enderror
                                    <label for="name"
                                        class="inline-block text-sm font-medium">{{ __('backend.name') }}</label>
                                    <input type="text" wire:model.defer="name" id="name" name="name"
                                        class="block w-full rounded-lg border border-gray-200 px-3 py-2 leading-6 placeholder-gray-500 focus:border-secondary-500 focus:ring focus:ring-secondary-500/50" />
                                </div>
                                <div class="space-y-1">
                                    @error('email')
                                        <p class="danger-error">
                                            {{ $message }}</p>
                                    @enderror
                                    <label for="email" class="inline-block text-sm font-medium">{{ __('backend.email') }}</label>
                                    <input type="email" id="email" wire:model.defer="email" name="email"
                                        class="block w-full rounded-lg border border-gray-200 px-3 py-2 leading-6 placeholder-gray-500 focus:border-secondary-500 focus:ring focus:ring-secondary-500/50" />
                                </div>
                                <div class="space-y-1">
                                    @error('password')
                                        <p class="danger-error">
                                            {{ $message }}</p>
                                    @enderror
                                    <label for="password"
                                        class="inline-block text-sm font-medium">{{ __('backend.password') }}</label>
                                    <input type="password" id="password" wire:model.defer="password" name="password"
                                        class="block w-full rounded-lg border border-gray-200 px-3 py-2 leading-6 placeholder-gray-500 focus:border-secondary-500 focus:ring focus:ring-secondary-500/50" />
                                </div>

                                
                                <div>
                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-primary-700 bg-primary-700 px-6 py-3 leading-6 font-semibold text-white hover:border-primary-600 hover:bg-primary-600 hover:text-white focus:ring focus:ring-primary-400/50 active:border-primary-700 active:bg-primary-700">
                                        <span>{{ __('backend.register') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign up with email -->
                    </div>
                <!-- END Sign up Section -->

            </div>
        </main>
        <!-- END Page Content -->
    </div>
    <!-- END Page Container -->

</div>
