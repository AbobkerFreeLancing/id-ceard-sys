<div class="bg-light py-4">
    {{-- ---------------- --}}
    <section class="bg-soft min-h-screen">
        <div class="container py-8 lg:max-w-5xl">
            <!-- Main -->
            <div class="order-2 lg:order-1 space-y-6">
                <!-- Top bar -->
                <div class="">
                    <div class="font-bold text-xl">{{ __('backend.dashboard') }}</div>
                    @if(!customer()->hasVerifiedEmail())
                    <div class="text-sm flex items-center gap-3 lg:text-base mt-3 bg-red-50 text-red-600 rounded-lg border border-red-200 px-4 py-1">
                        <x-tabler-mail class="inline-block size-6" />
                        {{ __('backend.verify_account_via_email') }}
                    </div>
                    @endif
                </div>

                <!-- Progress bar -->
                <div class="h-1 bg-amber-500 rounded">
                    <div class="h-full bg-brand-red rounded" style="width:65%"></div>
                </div>

                <!-- Welcome card -->
                <div style="background: linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.5)) ,url({{ asset('static/flag.jpg') }});background-size:cover;background-position:center"
                    class="bg-gradient-to-l from-brand-dark to-gray-900 text-white rounded-2xl p-8">
                    <h2 class="text-xl md:text-3xl font-bold"><span
                            class="font-normal">{{ __('backend.welcome') }}</span> {{ customer()?->name }}</h2>
                    <p class="mt-3 text-gray-300 text-sm max-w-xl">
                        {{ customer()?->email }}
                    </p>
                    <button
                        class="mt-5 bg-white text-black px-4 py-2 rounded-lg font-bold hover:bg-gray-100 text-sm">واصل
                        التعلم الآن</button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" style="display:none">
                    @foreach (range(1, 4) as $i => $stat)
                        <div class="card bg-white p-5 flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Title here</div>
                                <div class="text-2xl font-extrabold text-ink mt-1">43</div>
                            </div>
                            <div class="w-10 h-10 rounded bg-soft flex items-center justify-center">
                                icon
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Active courses + upcoming -->
                <div class="grid lg:grid-cols-1 gap-5">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-ink">{{ __('backend.active_subs') }}</h3>
                            {{-- <a href="#" class="text-xs text-brand-red font-bold">عرض الكل</a> --}}
                        </div>
                        <div class="gap-y-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
                            @if (1==1)
                                {{-- @foreach (customer()->enrolments()->notCompleted()->get() as $active) --}}
                                @foreach (range(1,4) as $item)
                                    <div class="card bg-white p-4 flex gap-4">
                                        <img src="{{ asset('static/client/featured_image.jpg') }}"
                                            class="w-28 h-24 rounded-lg object-cover" alt="">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs bg-green-600 text-white px-2 py-1 rounded">
                                                   title here
                                                </span>
                                                <span class="ms-auto text-xs text-gray-500">
                                                    duration
                                                </span>
                                            </div>
                                            <div class="font-bold text-ink text-sm">
                                                title
                                            </div>
                                            <div class="text-xs text-gray-500 mt-2">
                                                -
                                                {{ __('backend.joined_at') }} :
                                                2026/5
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Empty States: With Placeholders -->
                                <div
                                    class="rounded-xl col-span-2 border-2 border-dashed border-gray-200 px-6 py-8 dark:border-gray-700">
                                    <div class="flex flex-col gap-5 text-center">
                                        <div class="relative inline-flex items-center justify-center">
                                            <x-tabler-folder-exclamation class="inline-block size-12 text-gray-200" />
                                        </div>
                                        <div class="mx-auto w-full max-w-sm">
                                            <h3 class="mb-2 text-xl font-bold">{{ __('backend.no_active_courses') }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('courses') }}"
                                                class="group inline-flex items-center justify-center gap-2 rounded-lg border border-amber-700 bg-amber-600 px-3 py-2 text-sm leading-5 font-semibold text-white hover:border-amber-700 hover:bg-amber-700 hover:text-white focus:ring-3 focus:ring-amber-400/50 active:border-amber-700 active:bg-amber-700 dark:focus:ring-amber-400/90">
                                                <x-tabler-plus class="inline-block size-4 text-gray-200" />
                                                <span>{{ __('backend.courses_explore') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>

            <!-- Sidebar -->
            {{-- @include('inc.dashboard.sidebar') --}}
        </div>
    </section>
    {{-- ---------------- --}}
</div>
