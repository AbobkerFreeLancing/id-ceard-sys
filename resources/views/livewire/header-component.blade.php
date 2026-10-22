<header class="site-header">
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5">
        <div class="flex flex-wrap justify-between items-center container">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ dev()->admin_logo_url }}" class="me-3 h-9 sm:h-11" alt="Logo" />
            </a>

            <div class="flex items-center lg:order-2 hidden">
                <button type="button"
                    class="flex mx-3 text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ asset('frontend/img/profile_picture.jpg') }}" alt="user photo">
                </button>

                <!-- Dropdown menu -- -->
                <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow"
                    id="dropdown">
                    <div class="py-3 px-4">
                        <span class="block text-sm font-semibold text-gray-900">
                            {{  auth()?->user()?->name}}
                        </span>
                        <span class="block text-sm font-light text-gray-500 truncate">
                            {{  auth()?->user()?->email }}
                        </span>
                    </div>
                    <ul class="py-1 font-light text-gray-500" aria-labelledby="dropdown">
                        <li>
                            <a href="$" class="block py-2 px-4 text-sm hover:bg-gray-100">
                                {{ __('backend.my_profile') }}
                            </a>
                        </li>
                    </ul>

                    {{-- <ul class="py-1 font-light text-gray-500" aria-labelledby="dropdown">
                        <li>
                            <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-100">
                                {{ __('backend.logout') }}
                            </a>
                        </li>
                    </ul> --}}
                </div>
                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ms-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    @if (config('bedaya.blog_enabled'))
                        <li>
                            <a href="{{ route('blog') }}"
                                class="block py-2 pe-4 ps-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0">{{ __('backend.news_and_activities') }}</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</header>
