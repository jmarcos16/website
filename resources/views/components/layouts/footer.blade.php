<div>
    <footer class="relative bottom-0 top-auto mt-20 text-gray-400 bg-gradient-to-r from-gray-900 to-sky-900">
        <div class="px-4 py-12 mx-auto overflow-hidden max-w-7xl sm:px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="{{route('posts.index')}}" class="text-base text-gray-400 hover:text-white">
                        Artigos
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-400 hover:text-white">
                        Projetos
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-400 hover:text-white">
                        Sobre
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{route('contact')}}" class="text-base text-gray-400 hover:text-white">
                        Contato
                    </a>
                </div>
            </nav>
            <p class="mt-8 text-base text-center text-gray-400">
                &copy; {{ date('Y')}} All rights reserved.
            </p>
        </div>
    </footer>
</div>
