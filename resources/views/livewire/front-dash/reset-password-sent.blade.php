<div>
<div class="mx-auto flex w-full bg-gray-50 flex-col py-4">
  <main class="flex max-w-full flex-auto flex-col">
    <div class="relative mx-auto flex w-full max-w-10xl items-center justify-center overflow-hidden p-4">
      <section class="w-full bg-white text-center rounded-xl border border-gray-100 max-w-xl p-4">
        <x-tabler-mail class="inline-block size-8 mb-2 mx-auto text-center text-green-500" />
        <h3 class="mx-auto text-center text-lg">{{ __('backend.password_reset_sent_email') }}</h3>
        {{-- <p>{{session()->email}}</p> --}}
      </section>
    </div>
  </main>
</div>
{{-- ---- --}}
</div>
