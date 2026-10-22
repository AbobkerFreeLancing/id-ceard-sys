<div x-data="{ sidebarOpen: false }" class="relative">

    <button @click="sidebarOpen = !sidebarOpen"
        class="fixed bottom-3 end-3 z-50 lg:hidden size-10 p-2 hover:bg-slate-600 transition-colors rounded-lg text-white bg-slate-500">
        <template x-if="sidebarOpen">
        <x-tabler-x class="inline-block size-4 white" />
        </template>
        <template x-if="!sidebarOpen">
        <x-tabler-menu-2 class="inline-block size-4 white" />
        </template>
        {{-- <span x-text="sidebarOpen ? 'close' : 'menu'"> --}}
        </span>
    </button>

    <div class="flex">

        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 top-16 bg-slate-900/50 backdrop-blur-sm z-30 lg:hidden" x-cloak>
        </div>

        <aside
            class="fixed left-0 w-72 h-screen flex flex-col border-r border-slate-200/10 p-6 overflow-y-auto bg-slate-50 font-inter text-[13px] leading-6 z-40 transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="mb-8">
                <h3 class="font-manrope font-bold text-slate-900 tracking-wider text-sm mb-1">
                    {{ $project->name }}
                </h3>
                <p class="text-slate-400 text-[10px]">v1.0.0</p>
            </div>
            <nav class="flex flex-col gap-1 flex-1">
                <div>
                    <a class="flex items-center gap-3 bg-slate-200 text-slate-900 rounded-lg font-semibold px-3 py-1.5 transition-all"
                        href="#">
                        <x-tabler-home class="inline-block size-4 text-primary-500" />
                        Getting Started
                    </a>
                </div>

                @if ($project->sections()->exists())
                    @foreach ($project->sections as $section)
                        {{-- ---- Section Start ---- --}}
                        <div class="mt-2">
                            <a class="flex items-center gap-3 text-slate-500 hover:text-slate-800 px-3 py-1.5 transition-all font-semibold"
                                href="#{{ $section->slug }}" @click="sidebarOpen = false">
                                {{ $section->title }}
                            </a>
                            {{-- ---- --}}
                            <div class="ms-7 mt-1 flex flex-col gap-1 border-l border-slate-200">
                                @foreach ($section->items as $item)
                                    <a class="ps-4 py-1 text-primary-500 font-medium" href="#{{ $item->slug }}"
                                        @click="sidebarOpen = false">{{ $item->title }}</a>
                                @endforeach
                            </div>
                        </div>
                        {{-- ---- Section End ---- --}}
                    @endforeach
                @endif
            </nav>
        </aside>

        <main class="lg:ms-72 flex-1 px-6 md:px-12 py-12 lg:py-16 max-w-none w-full">
            <div class="max-w-4xl mx-auto lg:mx-0">
                <header class="mb-12">
                    <div class="flex items-center gap-2 text-secondary-500 mb-4">
                        <span class="text-xs text-slate-400">Last updated: {{ $project->nice_updated }}</span>
                    </div>
                    <h1 class="text-2xl md:text-4xl font-extrabold tracking-tight text-slate-900 mb-6 font-headline">
                        {{ $project->name }}
                    </h1>
                    <p class="text-base md:text-lg text-secondary-500 leading-relaxed max-w-3xl">
                        {{ $project->description }}
                    </p>
                </header>

                <section class="mb-16" id="base-url">
                    <h3 class="text-xl font-bold mb-6 font-headline">Base URL</h3>
                    <p class="mb-4">
                        All API requests should be made to this base endpoint:
                    </p>
                    <div class="bg-surface-400 rounded-xl overflow-hidden">
                        <div class="bg-slate-800 px-6 py-2 flex justify-between items-center">
                            <span class="text-xs font-mono text-slate-400">Endpoint</span>
                        </div>
                        <pre class="p-4 md:p-6 font-mono text-sm leading-6 overflow-x-auto text-slate-200 bg-slate-900"><code>{{ $project->base_api_url }}</code></pre>
                    </div>
                </section>

                @if ($project->sections()->exists())
                    @foreach ($project->sections as $sec)
                        <section class="pt-12 md:pt-16 mt-12 md:mt-16 border-t border-slate-200"
                            id="{{ $sec->slug }}">
                            <div class="flex items-center gap-2 text-primary-500 mb-4">
                                <span class="text-xs font-bold uppercase tracking-widest">API Reference</span>
                            </div>
                            <h2
                                class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900 mb-8 font-headline">
                                {{ $sec->title }}
                            </h2>

                            @foreach ($sec->items as $item)
                                <div id="{{ $item->slug }}" class="item-details mb-16 md:mb-20">
                                    <div class="flex flex-col md:flex-row md:items-baseline gap-2 md:gap-4 mb-4">
                                        <span
                                            class="w-fit px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">
                                            {{ $item?->request_method }}
                                        </span>
                                        <code class="text-lg md:text-xl font-mono font-bold text-slate-800 break-all">
                                            {{ $item?->endpoint }}
                                        </code>
                                    </div>
                                    <p class="text-slate-600 mb-6">
                                        {{ $item?->description }}
                                    </p>

                                    <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">
                                        Query Parameters
                                    </h4>
                                    <div class="bg-surface-200 rounded-xl overflow-x-auto mb-6">
                                        <div class="min-w-[400px]">
                                            <div
                                                class="grid grid-cols-3 p-4 border-b border-slate-300 text-xs font-bold uppercase tracking-widest text-slate-400">
                                                <div>Parameter</div>
                                                <div>Type</div>
                                                <div>Description</div>
                                            </div>
                                            <div class="grid grid-cols-3 p-4 text-sm border-b border-slate-200">
                                                <div class="font-mono text-primary-500">limit</div>
                                                <div class="text-slate-400">integer</div>
                                                <div class="text-slate-700">
                                                    Max number of users. Default: 20
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-3 p-4 text-sm">
                                                <div class="font-mono text-primary-500">offset</div>
                                                <div class="text-slate-400">integer</div>
                                                <div class="text-slate-700">Initial index for list.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">
                                        Response Example
                                    </h4>
                                    <div class="bg-surface-400 rounded-xl overflow-hidden">
                                        <div class="bg-slate-900 px-6 py-2 flex justify-between items-center">
                                            <span class="text-xs font-mono text-slate-400">200 OK — JSON</span>
                                        </div>
                                        <pre class="p-4 md:p-6 font-mono text-sm leading-6 overflow-x-auto text-slate-200 bg-slate-900"><code class="language-php">{{ $item->content }}</code></pre>
                                    </div>

                                    <h4 class="text-sm font-bold uppercase mt-4 tracking-wider text-slate-400 mb-3">
                                        Response
                                    </h4>
                                    <div
                                        class="flex items-center gap-3 p-4 bg-slate-100 border border-slate-200 rounded-lg text-slate-700 font-medium text-sm">
                                        <span class="material-symbols-outlined flex-shrink-0">delete_sweep</span>
                                        <span>204 No Content: Resource successfully deleted.</span>
                                    </div>

                                </div>
                            @endforeach
                        </section>
                    @endforeach
                @endif
            </div>
        </main>
    </div>

    <footer class="lg:ms-72 bg-surface-600 px-6 py-8 md:p-12 border-t border-slate-200/10">
        <div
            class="max-w-5xl mx-auto mt-12 pt-8 border-t border-slate-300 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-400 text-center sm:text-left">
                Developed By Mustafa Online © {{ date('Y') }}
            </p>
            <div class="flex gap-4">
                <span class="text-xs text-slate-400 font-medium">All rights reserved</span>
            </div>
        </div>
    </footer>
</div>
