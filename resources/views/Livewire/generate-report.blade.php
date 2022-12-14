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
                <option value="vehiculosMasCotizados">Vehículos más cotizados</option>
                <option value="ventasNoConcretadas">Ventas no concretadas</option>
            </select>
        </div>
        <div class="flex space-x-4 mb-4">
            <div>
                Desde la fecha:
                <x-jet-input type="date" class="w-36" wire:model="startDate"
                    max="{{ now()->toDateString('Y-m-d') }}" />
            </div>
            <div>
                Hasta la fecha:
                <x-jet-input type="date" class="w-36" wire:model="endDate"
                    max="{{ now()->toDateString('Y-m-d') }}" />
            </div>
        </div>
        @if (count($result) > 0)
            <x-jet-button wire:click="generateReportExcel">Exportar a excel</x-jet-button>
            <x-jet-button wire:click="generateReportPDF">Exportar a PDF</x-jet-button>
        @endif
        <div class="scroll-containerChico mx-auto">

            <div class="mt-4">
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
                                        @foreach ($element as $key => $value)
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="mr-2">
                                                        <span class="font-medium">
                                                            @if ($key !== 'Vehiculos')
                                                                {{ $value }}
                                                            @else
                                                                <ul>
                                                                    @foreach ($value as $vehicle)
                                                                        <li>
                                                                            - {{ $vehicle['Marca'] }}
                                                                            {{ $vehicle['Modelo'] }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </span>
                                                    </div>
                                            </td>
                                        @endforeach
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
    </div>
</div>
