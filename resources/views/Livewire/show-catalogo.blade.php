<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <section class="min-h-screen body-font text-gray-600 ">
        <div class="px-6 py-4 flex item-center">
            <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                placeholder="Busque un vehículo por marca, modelo o año." />
            {{-- BUSCADOR --}}
        </div>
        <div class="scroll-container grid sm:grid-cols-1 md:grid-cols-3">
            @if ($vehiculos->count())
                <div class="container mx-auto px-5 py-10">
                    <div class="-m-4 flex flex-wrap">
                        @foreach ($vehiculos as $veh)
                            <div class="w-full p-4 md:w-1/2 lg:w-1/4">
                                <a href="{{ route('quotations.simularCotizacion', $veh->id) }}"
                                    class="relative block h-48 overflow-hidden rounded">
                                    <img class="block h-full w-full object-cover object-center cursor-pointer"
                                        src="{{ $veh->image }}" />
                                </a>
                                <div class="mt-4">
                                    <h2 class="title-font text-lg font-medium text-gray-900">
                                        {{ $veh->vehicleModel->brand->name }}</h2>
                                    <h3 class="title-font mb-1 text-xs tracking-widest text-gray-500">
                                        {{ $veh->vehicleModel->name }}</h3>
                                    <p class="mt-1">{{ $veh->year }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="px-6 py-4">No se econtraron resultados</div>
            @endif
        </div>
    </section>
</div>
