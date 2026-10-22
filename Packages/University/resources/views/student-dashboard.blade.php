@php
    use App\Filament\Student\Resources\Assignments\AssignmentResource;
@endphp
<x-filament-panels::page>

    <div>
        {{-- --------------- --}}
        <!-- Main Content Area -->
        <main class="flex-1 w-full mx-auto">
            <div class="space-y-8">
                <p class="text-primary-800 mb-3 text-lg font-bold">
                    جامعة العلوم الصحية
                </p>
                <!-- Welcome Banner -->
                <section
                    class="relative overflow-hidden bg-blue-600 text-white rounded-2xl p-10 flex items-center justify-between shadow-lg shadow-blue-200">
                    <div class="z-10 max-w-lg">

                        <p class="text-white mb-2 text-base font-bold">
                            حساب الطالب
                        </p>
                        <h2 class="text-md lg:text-2xl mb-2">
                            <span>{{ __('backend.welcome_back') }}،</span>
                            @auth
                                <strong class="font-bold">{{ student()->halfName }}</strong>!
                            @endauth
                        </h2>
                    </div>
                    <div class="">
                        <x-tabler-book
                            class="inline-block absolute end-0 lg:end-10 bottom-0  top-auto lg:top-0 opacity-20 text-white size-32 lg:size-52" />
                    </div>
                </section>
                <!-- Bento Grid Layout -->
                <div class="grid grid-cols-12 gap-8">
                    <!-- Left Column: Stats and Content -->
                    <div class="col-span-12 lg:col-span-8 space-y-8">
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Stat Card -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-s-4 border-blue-500">
                                <p class="text-secondary-500 text-sm font-medium mb-1">
                                    {{ __('backend.university_no') }}
                                </p>
                                <div class="flex items-end gap-2">
                                    <span class="text-base lg:text-lg font-black text-secondary-900 font-headline">
                                        {{ student()->university_no }}
                                    </span>
                                </div>
                            </div>
                            <!-- Stat Card End -->
                            <!-- Stat Card -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-s-4 border-blue-500">
                                <p class="text-secondary-500 text-sm font-medium mb-1">
                                    {{ __('backend.college') }}
                                </p>
                                <div class="flex items-end gap-2">
                                    <span class="text-base lg:text-lg font-black text-secondary-900 font-headline">
                                        {{ student()->academicRecord?->college?->name }}
                                    </span>
                                </div>
                            </div>
                            <!-- Stat Card End -->

                            <!-- Stat Card -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-s-4 border-blue-500">
                                <p class="text-secondary-500 text-sm font-medium mb-1">
                                    {{ __('backend.acceptance_type') }}
                                </p>
                                <div class="flex items-end gap-2">
                                    <span class="text-base lg:text-lg font-black text-secondary-900 font-headline">
                                        {{ student()->academicRecord?->acceptanceType?->name }}
                                    </span>
                                </div>
                            </div>
                            <!-- Stat Card End -->


                        </div>

                    </div>
                    <!-- Right Column: Sidebar Content -->
                    <div class="col-span-12 lg:col-span-4 space-y-8">
                        <!-- Announcements -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                            <h3 class="text-base font-bold text-secondary-900 mb-6 flex items-center gap-2">
                                <x-tabler-speakerphone class="inline-block text-blue-500 size-6" />
                                <span>{{ __('backend.announcements') }}</span>
                            </h3>
                            <div class="space-y-4">
                                <h3 class="text-base font-semibold text-secondary-900 mb-6 flex items-center gap-2">
                                    قريباً
                                </h3>
                                @foreach (range(1, 3) as $announcement)
                                    <div style="display:none"
                                        class="flex gap-4 rounded-xl hover:bg-slate-50 transition-colors">
                                        <div
                                            class="w-13 h-13 p-1 rounded-lg bg-blue-50 text-blue-600 flex flex-col items-center justify-center border border-blue-100">

                                            <span class="text-xs font-bold">15</span>
                                            <span class="text-xs">أكتوبر</span>
                                            <span class="text-xs">2026</span>

                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-secondary-900">
                                                announcement->title
                                            </p>
                                            <p class="text-xs text-secondary-500">
                                                announcement->short_description
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </main>

        {{-- --------------- --}}
    </div>
</x-filament-panels::page>
