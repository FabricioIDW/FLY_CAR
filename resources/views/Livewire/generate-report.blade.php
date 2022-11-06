<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="bg-white rounded p-8 shadow mb-6">
        <h2 class="text-2x1 font-semibold mb-4">Generar reportes</h2>
        <div class="mb-4">
            <select name="serie" wire:model="report"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-50">
                <option value="">Seleccione el reporte</option>
                <option value="comisionesMensuales">Comisiones mensuales</option>
                <option value="modelosMasVendidos">Modelos más vendidos</option>
                <option value="accesoriosMasSolicitados">Accesorios más solicitados</option>
                <option value="ventasNoConcretadas">Ventas no concretadas</option>
                <option value="vehiculosMasCotizados">Vehículos más cotizados</option>
            </select>
        </div>
        <div class="flex space-x-4 mb-4">
            <div>
                Desde la fecha:
                <x-jet-input type="date" class="w-36" wire:model="startDate" />
            </div>
            <div>
                Hasta la fecha:
                <x-jet-input type="date" class="w-36" wire:model="endDate" />
            </div>
        </div>

        <x-jet-button wire:click="generateReport">Generar reporte</x-jet-button>


        @if ($report !== '' && $startDate !== '' && $endDate !== '')
            @if (count($result) > 0)
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            @php
                                foreach ($result[0] as $key => $value) {
                                    echo '<th class="py-3 px-6 text-left">' . $key . '</th>';
                                }
                            @endphp
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($result as $element)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                @php
                                    foreach ($element as $key => $value) {
                                        echo '<td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <span class="font-medium">' .
                                            $value .
                                            '</span>
                                    </div>
                            </td>';
                                    }
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Links --}}
                <div class="mt-4">
                    {{-- {{ $result->links() }} --}}
                </div>
            @else
                <p>No se encontraron resultados para este reporte con las fechas seleccionadas.</p>
            @endif
        @else
            <p>Debe ingresar todos los datos.</p>
        @endif

    </div>
</div>
