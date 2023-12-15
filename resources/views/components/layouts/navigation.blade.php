<nav class="bg-gradient-to-r from-gray-900 to-sky-900 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="shrink-0 flex items-center">
                <a href="#">
                    <span class="font-bold text-2xl text-gray-200">
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

                <!-- Search button -->

                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" 
                        class="w-6 h-6 text-gray-100 border border-white rounded-lg
                            p-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>

                </button>



            </div>


        </div>
    </div>
</nav>
