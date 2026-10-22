<div>
{{-- ---- --}}
<!-- Pages: Password Reset: Boxed -->
<div class="mx-auto flex w-full min-w-[320px] flex-col py-4">
  <!-- Page Content -->
  <main class="flex max-w-full flex-auto flex-col">
    <div class="relative mx-auto flex w-full max-w-10xl items-center justify-center overflow-hidden p-4">
      <!-- Password Reset Section -->
      <section class="w-full max-w-xl py-4">
        <h3 class="mx-auto text-center mb-2 text-lg">{{ __('backend.reset_password') }}</h3>
        <!-- Password Reset Form -->
        <div class="flex flex-col overflow-hidden rounded-lg bg-white shadow-md border border-gray-100">
          <div class="grow p-5 md:px-16 md:py-12">
            <form class="space-y-6" wire:submit.prevent="resetPassword">
              <div class="space-y-1">
                <label for="email" class="text-sm font-medium">{{ __('backend.email') }}</label>
                <input wire:model="email" class="block w-full rounded-lg border border-gray-300 px-5 py-2 leading-6 placeholder-gray-500 
                focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                  type="email" id="email" name="email" />
              </div>
              @error('no_customer_found')
                  <p class="bg-red-50 text-red-600 px-2 border border-red-100">{{$message}}</p>
                @enderror
              <div>
                <button type="submit"
                  class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg px-5 py-2.5 text-center"
                >
                  <span>{{ __('backend.reset_password') }}</span>
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
