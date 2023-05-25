<nav x-data="{ open: false }" class="py-1 border-slate-800 border-b-[1px] text-slate-200 bg-slate-950">
    <div class="flex-wrap items-center justify-between block p-2 px-8 mx-auto lg:flex">
        <div class="flex justify-between">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <img src="{{ asset('assets/images/trenggalek.png') }}" class="h-12 px-[1px] py-[2px] mr-3 bg-gray-800 rounded-md" alt="Flowbite Logo" />
                    @isset($pageTitle)
                        <span class="self-center text-xl font-bold whitespace-nowrap">{{ $pageTitle }}</span>
                    @endisset
                    @empty($pageTitle)
                        <span class="self-center text-xl font-bold whitespace-nowrap">Wisata Trenggalek</span>
                    @endempty
                </a>
                <div class="ml-10">
                    <ul class="flex items-center w-full py-2 space-x-2">
                        <li class="px-2">
                            <x-nav-link class="text-lg text-slate-300 hover:text-slate-50" :href="route('welcome')" :active="request()->routeIs('welcome')">
                                {{ __('Home') }}
                            </x-nav-link>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open">
                    <svg x-cloak x-show="!open" xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 6l16 0"></path>
                        <path d="M4 12l16 0"></path>
                        <path d="M4 18l16 0"></path>
                    </svg>
                    <svg x-cloak x-show="open" xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="items-center block">
            {{-- Primary Navbar --}}
            <div class="items-center hidden lg:flex">
                <ul class="flex items-center w-full py-2 space-x-2">
                    <li class="px-2">
                        @auth
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                        <div class="">
                                            @if (auth()->user()->avatar_name)
                                                <div class="rounded-full w-[32px] h-[32px]">
                                                     <img class="object-cover w-full h-full rounded-full"
                                                        src="{{ asset('storage/avatars/' . auth()->user()->avatar_name) }}"
                                                        alt="{{ auth()->user()->name }}">
                                                </div>
                                            @else
                                                <img class="flex items-center justify-center rounded-full w-[32px] h-[32px] border-2 border-gray-500"
                                                    src="{{ Avatar::create(auth()->user()->name)->setDimension(100, 100)->toBase64() }}"
                                                    alt="{{ auth()->user()->name }}">
                                            @endif
                                        </div>

                                        <div class="ml-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <x-nav-link class="text-lg text-slate-300 hover:text-slate-50" :href="route('login')">
                                {{ __('Login') }}
                            </x-nav-link>
                        @endauth
                    </li>
                </ul>
            </div>
            {{-- Mobile Responsive Navbar --}}
            <div x-cloak x-show="open" x-data="{ toggleDropdown: false }" x-transition:enter="transform duration-200"
                x-transition:enter-start="opacity-0 -translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transform duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2" class="mt-2 bg-gray-200 rounded-md lg:hidden">
                <ul class="block w-full py-2 space-y-2">
                    <li class="px-2">
                        <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                            {{ __('Home') }}
                        </x-nav-link>
                    </li>
                    @auth
                        <li class="px-3 text-sm font-semibold text-gray-900">
                            <button class="flex items-center mt-5 hover:underline" @click="toggleDropdown = ! toggleDropdown">
                                @if (auth()->user()->avatar_name)
                                    <img class="mr-2 rounded-full w-7 h-7"
                                        src="{{ asset('storage/avatars/' . auth()->user()->avatar_name) }}"
                                        alt="{{ auth()->user()->name }}">
                                @else
                                    <img class="flex items-center justify-center mr-2 rounded-full w-7 h-7"
                                        src="{{ Avatar::create(auth()->user()->name)->setDimension(100, 100)->toBase64() }}"
                                        alt="{{ auth()->user()->name }}">
                                @endif
                                {{ auth()->user()->name }}
                                <div class="mt-1 ml-1">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-chevron-right"
                                        :class="{ 'rotate-90 duration-200': toggleDropdown, 'duration-200': !toggleDropdown }"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 6l6 6l-6 6"></path>
                                    </svg>
                                </div>
                            </button>
                        </li>
                    @endauth
                    <li class="px-2">
                        @auth
                            <div x-cloak x-show="toggleDropdown" x-transition:enter="transform duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-6"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transform duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2">
                                <ul class="block px-2 py-2 space-y-2 bg-gray-300 rounded-md">
                                    <li>
                                        <x-nav-link :href="route('dashboard')">
                                            {{ __('Dashboard') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-nav-link>
                                    </li>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-nav-link>
                                    </form>
                                </ul>
                            </div>
                        @else
                            <x-nav-link :href="route('login')">
                                {{ __('Login') }}
                            </x-nav-link>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
