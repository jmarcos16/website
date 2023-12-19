<x-main-layout title="Contato">
    <div>
        <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <span class="text-2xl font-bold border-b">Entre em contato</span>
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="col-span-2">
                    <div>
                        <div class="mt-6">
                            <form action="mailto:{{ env('CONTACT_EMAIL') }}" method="post" enctype="text/plain" class="space-y-10">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Nome
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" autocomplete="given-name"
                                            class="block w-full px-4 py-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="mail" name="mail" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <div class="mt-1">
                                        <input id="email" name="email" type="text" autocomplete="email"
                                            class="block w-full px-4 py-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">
                                        Telefone
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="phone" id="phone" autocomplete="phone"
                                            class="block w-full px-4 py-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">
                                        Mensagem
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="message" name="message" rows="5"
                                            class="block w-full px-4 py-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="inline-flex justify-center px-6 py-2 text-base font-medium text-white bg-gray-900 border border-transparent rounded-md shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus :ring-offset-2 focus:ring-gray-500">
                                        Enviar
                                    </button>
                                    {{-- Reset  --}}
                                    <button type="reset"
                                        class="inline-flex justify-center px-6 py-2 text-base font-medium border rounded-md shadow-sm bg-gray-50 text-gry-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus :ring-offset-2 focus:ring-gray-500">
                                        Limpar
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-main-layout>
