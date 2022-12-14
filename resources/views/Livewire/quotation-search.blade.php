<div>
    {{-- Quotation table --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="px-6 py-4 flex item-center">
            <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                placeholder="Escriba lo que quiere buscar" />
        </div>

        {{-- @if (count($quotations) > 0) --}}
        @if ($quotations->count())
            <div class="scroll-containerChico mx-auto">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            {{-- Número de cotización --}}
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('id')">Nro.</th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            {{-- Fecha generada --}}
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('dateTimeGenerated')">Fecha
                                generada
                            </th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'dateTimeGenerated')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            {{-- Fecha de vencimiento --}}
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('dateTimeExpiration')">
                                Fecha de
                                vencimiento</th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'dateTimeExpiration')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            {{-- Importe --}}
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('finalAmount')">Importe
                            </th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'finalAmount')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            {{-- DNI del cliente --}}
                            <th class="cursor-pointer py-3 px-6 text-left">DNI del cliente</th>
                            <th class="cursor-pointer py-3 px-6 text-left">Estado</th>
                            <th class="cursor-pointer py-3 px-6 text-center col-span-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($quotations as $quotation)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                {{-- Número de cotización --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span class="font-medium">{{ $quotation->id }}</span>
                                        </div>
                                </td>
                                {{-- Fecha generada --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $quotation->dateTimeGenerated }}</span>
                                    </div>
                                </td>
                                {{-- Fecha de vencimiento --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $quotation->dateTimeExpiration }}</span>
                                    </div>
                                </td>
                                {{-- Importe --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>${{ number_format($quotation->finalAmount, 2, ',', '.') }}</span>
                                    </div>
                                </td>
                                {{-- DNI del cliente --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        @if ($quotation->customer)
                                            <span>{{ $quotation->customer->dni }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        @php
                                            if ($quotation->reserve) {
                                                echo '<span>Reservada</span>';
                                            } else {
                                                echo '<span>Sin reserva</span>';
                                            }
                                        @endphp
                                        {{-- <span>{{ $quotation->reserve }}</span> --}}
                                    </div>
                                </td>
                                {{-- {{route('quotations.seeQuotation', $quotation->id)}} --}}
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div>
                                            <a href="{{ route('quotations.seeQuotation', $quotation->id) }}">
                                                <x-button-normal openBtn="Ver" />
                                            </a>
                                        </div>
                                        @if ($quotation->reserve)
                                            @if (!($quotation->reserve->reserveState == 'enabled' && $quotation->checkVehiclesState()))
                                                <div>
                                                    <a href="{{ route('quotations.seeQuotation', $quotation->id) }}">
                                                        {{-- TO DO cambiar el ícono para cancelar reserva --}}
                                                        <x-button-normal openBtn="Cancelar reserva" />
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-4">
                No existen cotizaciones que coincidan.
            </div>
        @endif
    </div>
</div>
