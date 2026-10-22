 <header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-slate-200">
     @php
         use App\Providers\Filament\SeekerPanelProvider;
         use Filament\Facades\Filament;
     @endphp
     <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
         <div class="flex h-16 items-center justify-between">
             <!-- Left: Brand -->
             <a href="#" class="flex items-center gap-2">
                 <span
                     class="inline-flex gap-2 px-2 h-9 items-center justify-center rounded-lg text-primary-600 font-bold">
                     <x-tabler-briefcase class="hi-solid hi-inbox text-primary-600 inline-block size-6" />
                     <span>UHS للتوظيف</span>
                 </span>
                 <span class="sr-only">UHS</span>
             </a>

             <!-- Center: Nav (lg+) -->
             <nav class="hidden lg:flex items-center gap-8 text-sm">
                 <a class="font-medium text-slate-700 hover:text-primary-600"
                     href="{{ route('career_home') }}">{{ __('backend.home') }}</a>
                 <a class="font-medium text-slate-700 hover:text-primary-600"
                     href="#">{{ __('backend.contact_us') }}</a>
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
                                 class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm leading-5 font-semibold text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-xs focus:ring-3 focus:ring-gray-300/25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600/40 dark:active:border-gray-700"
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
                                 class="absolute start-0 rtl:end-0 rtl:start-auto z-10 mt-2 w-64 origin-top-start rounded-lg shadow-xl dark:shadow-gray-900">
                                 <div class="divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-black/5">
                                     <div class="flex items-center gap-3 px-5 py-3">
                                         <img src="{{ asset('static/filament_avatar.jpg') }}" alt="User Avatar"
                                             class="inline-block size-10 flex-none rounded-full" />
                                         <div class="grow text-sm">
                                             <a href="javascript:void(0)"
                                                 class="font-semibold text-gray-600 hover:text-gray-500">
                                                 {{ auth('seekers')->user()->name }}
                                             </a>
                                             <p class="text-xs font-medium break-all text-gray-500">
                                                 {{ auth('seekers')->user()->email }}
                                             </p>
                                         </div>
                                     </div>
                                     <div class="space-y-1 p-2.5">
                                         <a role="menuitem" href="{{ Filament::getPanel('seeker')->getUrl() }}"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600">
                                             <x-tabler-home-2 class="hi-solid hi-inbox inline-block size-5" />
                                             <span class="grow">{{ __('backend.dashboard') }}</span>
                                         </a>

                                     </div>
                                     <div class="space-y-1 p-2.5">
                                         <a role="menuitem" href="javascript:void(0)"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600">
                                             <svg class="hi-mini hi-user-circle inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                 aria-hidden="true">
                                                 <path fill-rule="evenodd"
                                                     d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                                     clip-rule="evenodd" />
                                             </svg>
                                             <span class="grow">Account</span>
                                         </a>
                                         <a role="menuitem" href="javascript:void(0)"
                                             class="group flex items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600">
                                             <svg class="hi-mini hi-cog-6-tooth inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                 aria-hidden="true">
                                                 <path fill-rule="evenodd"
                                                     d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                     clip-rule="evenodd" />
                                             </svg>
                                             <span class="grow">Settings</span>
                                         </a>
                                     </div>
                                     <div class="space-y-1 p-2.5">
                                         <form onsubmit="return false;">
                                             <button type="submit" role="menuitem"
                                                 class="group flex w-full items-center justify-between gap-2 rounded-lg border border-transparent px-2.5 py-2 text-start text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600">
                                                 <svg class="hi-mini hi-lock-closed inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                     <path fill-rule="evenodd"
                                                         d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                                         clip-rule="evenodd" />
                                                 </svg>
                                                 <span class="grow">{{ __('backend.logout') }}</span>
                                             </button>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                             <!-- END Dropdown -->
                         </div>
                         <!-- Dropdown Container -->
                     </div>
                     {{-- -------- --}}
                 @else
                     <a href="#"
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
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100" href="#jobs">Jobs</a>
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100" href="#companies">Companies</a>
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100" href="#resources">Resources</a>
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100" href="#pricing">Pricing</a>
                 <a class="rounded-lg px-3 py-2 hover:bg-slate-100" href="#signin">Sign in</a>
             </nav>
         </div>
     </div>
 </header>
