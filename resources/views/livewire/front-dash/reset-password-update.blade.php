<div>
{{-- ---- --}}
<!-- Pages: Password Reset: Boxed -->
<div class="mx-auto flex w-full min-w-[320px] bg-gray-50 flex-col py-4">
  <!-- Page Content -->
  <main class="flex max-w-full flex-auto flex-col">
    <div class="relative mx-auto flex w-full max-w-10xl items-center justify-center overflow-hidden p-4">
      <!-- Password Reset Section -->
      <section class="w-full max-w-xl py-4">
        <h3 class="mx-auto px-4 mb-2 text-lg font-semibold">{{ __('backend.update_password') }}</h3>
        <!-- Password Reset Form -->
        @if ($password_updated)
        <div class="rounded-lg border border-green-200 bg-green-100 p-4 py-3 text-green-700 mb-2">
          <div class="flex gap-4 items-center">
            <x-filament::icon icon="heroicon-s-check-circle" class="size-6 inline-block flex-none text-green-500" />
          <h3 class="grow font-semibold">{{ __('backend.password_reset_successfuly') }}</h3>
          </div>
          </div>
        @endif
        @if ($link_expired)
          <!-- Alerts: Warning -->
          <div class="rounded bg-orange-100 p-4 text-orange-700 md:p-5">
          <div class="flex items-center">
            <x-filament::icon icon="heroicon-s-exclamation-triangle" class="size-5 me-3 inline-block flex-none text-orange-500" />
          <h3 class="grow font-semibold">{{ __('backend.url_expired') }}</h3>
          </div>
          </div>
          <!-- END Alerts: Warning -->
        @else
        <div class="flex flex-col overflow-hidden rounded-lg bg-white shadow-md border border-gray-100">
          <div class="grow p-5 md:px-16 md:py-12">
            <form class="space-y-6" wire:submit.prevent="updatePassword">
              <div class="space-y-1">
                @error('password')
                  <p class="bg-red-50 text-red-600 px-2 border border-red-100">{{$message}}</p>
                @enderror
                <label for="password" class="text-sm font-medium">{{ __('backend.new_password') }}</label>
                <input wire:model="password" class="block w-full rounded-lg border border-gray-300 px-5 py-2 leading-6 placeholder-gray-500 
                focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                  type="password" id="password" name="password" />
              </div>
              <div class="space-y-1">
                <label for="password_confirmation" class="text-sm font-medium">{{ __('backend.confirm_new_password') }}</label>
                <input wire:model="password_confirmation" class="block w-full rounded-lg border border-gray-300 px-5 py-2 leading-6 placeholder-gray-500 
                focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                  type="password" id="password_confirmation" name="password_confirmation" />
              </div>
              <div>
                <button type="submit"
                  class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg px-5 py-2.5 text-center"
                >
                  <span>{{ __('backend.action_update') }}</span>
                </button>
              </div>
            </form>
          </div>
          <div
            class="grow bg-gray-100 p-5 text-center md:px-16"
          >
            <a href="{{ route('front_login') }}" class="font-medium text-primary-600 hover:text-primary-400">
                {{ __('backend.back_to_login') }}
            </a>
          </div>
        </div>
        <!-- END Password Reset Form -->
        @endif
      </section>
      <!-- END Password Reset Section -->
    </div>
  </main>
  <!-- END Page Content -->
</div>
<!-- END Page Container -->
<!-- END Pages: Password Reset: Boxed -->

{{-- ---- --}}
</div>
