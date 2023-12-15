<x-main-layout>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- <span>Laste</span> --}}
            <span class="text-2xl font-bold border-b">Ultimas publicações</span>
            <div class="grid grid-cols-3 gap-6">
                @for ($i = 1; $i < 9; $i++)
                <a href="#" class="col-span-1 py-5">
                    <img src="{{"https://api.slingacademy.com/public/sample-photos/{$i}.jpeg"}}" alt="">

                <!-- Date published  -->
                    <div class="flex py-3 gap-10">
                        <span class="text-gray-500">Dezembro 23</span>
                        <span class="text-gray-500">{{rand(1,20)}} min</span>
                    </div>

                    <div>
                        <div class="text-2xl font-bold">Como implementar router service provider no laravel 10</div>
                        <span class="text-gray-500">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores cum asperiores doloremque quae aspernatur delectus incidunt at excepturi! Animi esse voluptate, iure quo tempore nam mollitia odio quaerat aspernatur hic!</span>
                    </div>
                </a>
                @endfor
            </div>
        </div>
    </div>
</x-main-layout>
