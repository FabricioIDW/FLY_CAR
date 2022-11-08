<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="content">
        <div class="w-11/12 mx-auto place-items-center max-h-full">
            <div class="px-6 py-4 flex item-center">
                <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                    placeholder="Busque por id, stock o nombre del accesorio." />{{-- BUSCADOR --}}
                <a href="{{ route('productos.create') }}">
                    {{-- <x-button-normal openBtn="Crear accesorio"></x-button-normal> --}}
                    <x-jet-button>Crear accesorio</x-jet-button>
                </a>
            </div>
            <div class="scroll-containerChico mx-auto">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-center">ID</th>
                            <th class="py-3 px-6 text-center">Nombre</th>
                            <th class="py-3 px-6 text-center">Stock</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="alldataA" class="text-gray-600 text-sm font-light bg-gray-200">
                        @foreach ($accesorios as $accesorio)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <div class="items-center">
                                        <div class="mr-2">
                                            <span class="font-medium">{{ $accesorio->id }}</span>
                                        </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class=" items-center ">
                                        <span>{{ $accesorio->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class=" items-center">
                                        <span>{{ $accesorio->stock }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('accesorios.editar', $accesorio) }}">
                                            <x-button-normal openBtn="Editar" />
                                        </a>
                                        <div class="overflow-x-auto">
                                            <div class="overflow-x-auto">
                                                <x-button openBtn="Eliminar" value="{{ $accesorio->id }}"></x-button>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-modal title="Eliminar Accesorio" leftBtn="Eliminar" rightBtn="Cancelar" ref="accesorios.baja"
                    value="" id="idModal">
                    <p>¿Está seguro que desea eliminar este accesorio?</p>
                </x-modal>
            </div>
        </div>
    </div>
