<nav class="bg-gradient-to-r from-gray-900 to-sky-900">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center shrink-0">
                <a href="{{ route('posts.index') }}">
                    <span class="text-2xl font-bold text-gray-200">
                        phpislife
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link>
                    {{ __('Artigos') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Projetos') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Sobre') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Contato') }}
                </x-nav-link>
                <!-- Search button -->

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="relative w-5 h-5 translate-x-8 text-gray-50">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>

                    <input type="text"
                        class="px-3 py-1 pl-10 text-gray-100 bg-transparent border border-gray-100 rounded-lg outline-none border-opacity-30"
                        placeholder="Searchs">
                </div>
            </div>
        </div>
    </div>
</nav>
