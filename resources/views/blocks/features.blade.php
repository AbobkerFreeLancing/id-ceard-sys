@if ($block['type'] == 'features')
    <!-- Features Section: With Animated Borders Alternate -->
    <div class="bg-gray-50">
        <div class="container py-8">
            <h2 data-aos="fade-up" data-aos-duration="1000" class="text-lg lg:text-xl mb-4 font-bold text-primary-700">
                {{ $block['data']['title'] }}
            </h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 lg:grid-cols-3 xl:gap-8">
                @foreach ($block['data']['features'] as $jey => $ft)
                <div data-aos="fade-up" data-aos-duration="1000" class="group relative flex flex-col overflow-hidden rounded-lg">
                    <div class="relative grow rounded-lg bg-white p-4 lg:p-6">
                        <div class="relative mb-6 w-12 text-primary-500">
                            @svg($ft['icon'], 'absolute bottom-0 end-0 inline-block size-10 translate-x-2 translate-y-2 text-primary-200 transition group-hover:translate-x-0 group-hover:translate-y-0')

                            @svg($ft['icon'], 'relative inline-block size-12 transition group-hover:translate-x-1 group-hover:translate-y-1')
                        </div>
                        <h4 class="mb-3 text-lg lg:text-xl text-primary-800 font-bold">{{ $ft['title'] }}</h4>
                        <p class="font-medium leading-relaxed text-gray-600">
                            {{ $ft['subtitle'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END Features Section: With Animated Borders Alternate -->
@endif
