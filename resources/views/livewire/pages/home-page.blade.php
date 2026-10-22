<div class="hide-header hide-footer">
    {{-- --------------------------- --}}
    <div class="bg-cover " style="background-image: url({{ asset('static/hero_bg.jpg') }});background-size:cover">
        <div class="relative flex items-center justify-center h-screen bg-primary-800/90 bg-linear-to-r from-primary-700/90 via-transparent to-primary-800/90 backdrop-blur-xs">
            <!-- Hero Content -->
            <div class="relative container mx-auto px-4 py-16 text-center lg:px-8">
                <div class="mb-5 text-xl text-primary-200">
                    {{ settings()->tagline }}
                </div>
                <h1 class="mb-4 text-4xl font-bold text-white">
                    {{ settings()->company_name }}
                </h1>
                <p class="mx-auto max-w-2xl text-lg/relaxed font-medium text-gray-200 lg:text-xl/relaxed">
                    {{ settings()->description }}
                </p>
                <div style="display:none" class="mt-10 flex flex-wrap items-center justify-center gap-4 pb-16">
                    <a href="javascript:void(0)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-primary-700 bg-primary-700 px-5 py-3.5 leading-6 font-medium text-white hover:border-primary-600 hover:bg-primary-600 hover:text-white focus:ring-3 focus:ring-primary-400/90 active:border-primary-700 active:bg-primary-700">
                        <span>Get started</span>
                        <svg class="hi-mini hi-arrow-right inline-block size-5 opacity-50"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 px-5 py-3.5 leading-6 font-medium text-gray-100 hover:border-white/30 hover:text-gray-50 hover:shadow-xs focus:ring-3 focus:ring-white/10 active:border-white/20 active:shadow-none">
                        <span>Learn more</span>
                    </a>
                </div>
            </div>
            <!-- END Hero Content -->
        </div>
    </div>
    {{-- --------------------------- --}}
</div>
