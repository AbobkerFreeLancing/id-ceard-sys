 <header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-slate-200">
     @php
         use App\Providers\Filament\SeekerPanelProvider;
         use Filament\Facades\Filament;
         use App\Filament\Seeker\Resources\SeekerProfiles\SeekerProfileResource;
         use App\Filament\Seeker\Resources\SeekerResumes\SeekerResumeResource;
     @endphp
     <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
         <div class="flex h-16 items-center justify-between">
             <!-- Left: Brand -->
             <a href="#" class="flex items-center gap-2">
                 <img src="{{ asset('static/client/liva_logo.png') }}" style="height: 55px" alt="Logo">
             </a>

             <!-- Center: Nav (lg+) -->
             <nav class="hidden lg:flex items-center gap-8 text-sm">
                 {{-- <a class="font-medium text-slate-700 hover:text-primary-600"
                     href="#">{{ __('backend.home') }}</a>
                 --}}
             </nav>

             <!-- Right: Actions -->
             <div class="flex items-center gap-3">
                 @auth('seekers')
                     {{-- -------- --}}
                     <div class="flex justify-end">
                         <!-- Dropdown Container -->
                         <div x-data="{ open: false }" class="relative inline-block">
                             <!-- Dropdown Toggle Button -->
                             <button type="button"
                                 class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm leading-5 font-semibold text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-xs focus:ring-3 focus:ring-gray-300/25 active:border-gray-200 active:shadow-none"
                                 id="tk-dropdown" aria-haspopup="true" x-bind:aria-expanded="open"
                                 x-on:click="open = true">
                                 <span>{{ __('backend.my_account') }}</span>
                                 <svg class="hi-mini hi-chevron-down inline-block size-4 opacity-50"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                     <path fill-rule="evenodd"
                                         d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                         clip-rule="evenodd" />
                                 </svg>
                             </button>
                             <!-- END Dropdown Toggle Button -->

                             <!-- Dropdown -->
                             <div x-cloak x-trap="open" x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90" x-on:click.outside="open = false"
                                 x-on:keydown.down.prevent="$focus.next()" x-on:keydown.up.prevent="$focus.prev()"
                                 x-on:keydown.home.prevent="$focus.first()" x-on:keydown.end.prevent="$focus.last()"
                                 x-on:keydown.escape.window="open = false" role="menu" aria-labelledby="tk-dropdown"
                                 class="absolute start-0 rtl:end-0 rtl:start-auto z-10 mt-2 w-64 origin-top-start rounded-lg shadow-xl">
                                 <div class="divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-black/5">
                                     <div class="flex items-center gap-3 px-5 py-3">
                                         <img src="{{ asset('static/filament_avatar.jpg') }}" alt="User Avatar"
                                             class="inline-block size-10 flex-none rounded-full" />
                                         <div class="grow text-sm">
                                             <a class="font-semibold text-gray-600">
                                                 {{ auth('seekers')->user()->name }}
                                             </a>
                                             <p class="text-sm font-medium break-all text-gray-500">
                                                 {{ auth('seekers')->user()->email }}
                                             </p>
                                         </div>
                                     </div>

                                     <div class="space-y-1 p-2.5">
                                         <a role="menuitem" href="{{ Filament::getPanel('seeker')->getUrl() }}"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100">
                                             <x-tabler-home-2 class="hi-solid opacity-50 hi-inbox inline-block size-5" />
                                             <span class="grow">{{ __('backend.dashboard') }}</span>
                                         </a>
                                         <a href="{{ route('filament.seeker.resources.seeker-profiles.edit', [auth('seekers')->user()->slug]) }}"
                                             role="menuitem"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100">
                                             <x-tabler-edit class="hi-solid opacity-50 hi-inbox inline-block size-5" />
                                             <span class="grow">{{ __('backend.edit_profile_data') }}</span>
                                         </a>
                                         <a role="menuitem"
                                             href="{{ route('filament.seeker.resources.seeker-resumes.edit', [auth('seekers')->user()->slug]) }}"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100">
                                             <x-tabler-file-cv class="hi-solid opacity-50 hi-inbox inline-block size-5" />
                                             <span class="grow">{{ __('backend.resume') }}</span>
                                         </a>
                                         <a wire:click.prevent="logout" role="menuitem" href="#"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100">
                                             <x-tabler-lock class="hi-solid opacity-50 hi-inbox inline-block size-5" />
                                             <span class="grow">{{ __('backend.logout') }}</span>
                                         </a>
                                     </div>

                                 </div>
                             </div>
                             <!-- END Dropdown -->
                         </div>
                         <!-- Dropdown Container -->
                     </div>
                     {{-- -------- --}}
                 @else
                     <a href="{{ filament()->getPanel('seeker')->getLoginUrl() }}"
                         class="hidden sm:inline-flex text-sm font-medium text-slate-700 hover:text-primary-600">
                         {{ __('backend.login2') }}
                     </a>
                 @endauth



                 <!-- Mobile menu button -->
                 <button id="menuBtn"
                     class="lg:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 hover:bg-slate-100"
                     aria-label="Open menu">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                         <path d="M4 6h16M4 12h16M4 18h16" />
                     </svg>
                 </button>
             </div>
         </div>

         <!-- Mobile menu -->
         <div id="mobileMenu" class="lg:hidden hidden pb-4">
             <nav class="grid gap-2 text-sm">
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100"
                     href="#">{{ __('backend.home') }}</a>
                 @if (!auth('seekers')->check())
                     <a href="{{ filament()->getPanel('seeker')->getLoginUrl() }}"
                         class="rounded-lg px-3 py-2 hover:bg-slate-100">
                         {{ __('backend.login2') }}
                     </a>
                 @endif
             </nav>
         </div>
     </div>
 </header>
