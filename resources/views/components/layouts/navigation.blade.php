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
                    {{ __('Blog') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Sobre') }}
                </x-nav-link>
                <x-nav-link>
                    {{ __('Contato') }}
                </x-nav-link>

                <x-nav-link>
                    {{ __('Projetos') }}
                </x-nav-link>

                <!-- Search button -->
                <x-search-button/>
                
            </div>
        </div>
    </div>
</nav>
