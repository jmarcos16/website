<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-900 to-sky-900">
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
                <x-nav-link :href="route('posts.index')">
                    {{ __('Artigos') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Projetos') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Sobre') }}
                </x-nav-link>
                <x-nav-link :href="route('contact')">
                    {{ __('Contato') }}
                </x-nav-link>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-300 transition duration-150 ease-in-out rounded-md hover:text-gray-100 focus:outline-none">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('posts.index')">
                {{ __('Artigos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link>
                {{ __('Projetos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link>
                {{ __('Sobre') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact')">
                {{ __('Contato') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
