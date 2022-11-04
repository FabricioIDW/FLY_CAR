<div>
    {{-- Be like water. --}}

    <div class="content">
        {{-- Scroll Vehiculos  --}}
        <div class="w-11/12 mx-auto place-items-center max-h-full">
            <div class="text-2xl font-semibold text-center">Vehiculos</div>
            <div class="px-6 py-4 flex item-center">
                <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                    placeholder="Busque por id, modelo o marca." />{{-- BUSCADOR --}}
            </div>
            <div class="scroll-containerChico mx-auto">
                @if ($vehiculos->count())
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">ID</th>
                                <th class="py-3 px-6 text-center">Marca</th>
                                <th class="py-3 px-6 text-center">Modelo</th>
                                <th class="py-3 px-6 text-center">N° de chasis</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="alldataV" class="text-gray-600 text-sm font-light bg-gray-200">
                            @foreach ($vehiculos as $vehiculo)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                        <div class="items-center">
                                            <div class="mr-2">
                                                <span class="font-medium">{{ $vehiculo->id }}</span>
                                            </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="items-center">
                                            <span>{{ $vehiculo->vehicleModel->brand->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="items-center">
                                            <span>{{ $vehiculo->vehicleModel->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="items-center">
                                            <span>{{ $vehiculo->chassis }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('vehiculos.editar', $vehiculo) }}">{{-- EDITAR VEHICULO --}}
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </div>
                                            </a>
                                            <div class="overflow-x-auto">
                                                <div class="overflow-x-auto">
                                                    <x-button openBtn="Eliminar" value="{{ $vehiculo->id }}"></x-button>
                                                </div>
                                            </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-modal title="Eliminar Vehiculo" leftBtn="Eliminar" rightBtn="Cancelar" ref="vehiculos.baja"
                        value="" id="idModal">
                        <p>¿Seguro que quiere dar de baja a este vehículo?</p>
                    </x-modal>
                @else
                    <div class="px-6 py-4">No se econtraron resultados</div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
