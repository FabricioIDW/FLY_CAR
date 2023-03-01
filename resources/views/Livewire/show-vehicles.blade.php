<div>
    {{-- Be like water. --}}

    <div class="content">
        {{-- Scroll Vehiculos  --}}
        <div class="w-11/12 mx-auto place-items-center max-h-full">
            <div class="px-6 py-4 flex item-center">
                <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                    placeholder="Busque por N°, modelo o marca." />{{-- BUSCADOR --}}
                <a href="{{ route('productos.create') }}">
                    {{-- <x-button-normal openBtn="Crear vehículo"></x-button-normal> --}}
                    <x-jet-button>Crear vehículo</x-jet-button>
                </a>
            </div>
            <div class="scroll-containerChico mx-auto">
                @if ($vehiculos->count())
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">N°</th>
                                <th class="py-3 px-6 text-center">Marca</th>
                                <th class="py-3 px-6 text-center">Modelo</th>
                                <th class="py-3 px-6 text-center">N° de chasis</th>
                                <th class="py-3 px-6 text-center">Estado</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="alldataV" class="text-gray-600 text-sm font-light bg-white">
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
                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                        <div class="items-center">
                                            <div class="mr-2">
                                                @php
                                                    $estado = $vehiculo->vehicleState;
                                                    if ($estado == 'reserved') {
                                                        echo '<span class="font-medium">Reservado</span>';
                                                    } else {
                                                        echo '<span class="font-medium">Disponible</span>';
                                                    }
                                                @endphp
                                            </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('vehiculos.editar', $vehiculo) }}">
                                                <x-button-normal openBtn="Editar" />
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
                @else
                    <div class="px-6 py-4">No se econtraron resultados</div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="text-center">@include('layouts.partials.footer')</div>
</div>
