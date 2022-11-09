<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="w-11/12 mx-auto place-items-center max-h-full">
        {{-- max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-96 --}}

        <div class="px-6 py-4 flex item-center">
            {{-- <input type="text" wire:model="search"> --}}
            <x-jet-input class="flex-1 mr-4" type="text" wire:model="search"
                placeholder="Escriba lo que quiere buscar" />
            <a href="{{ route('offers.create') }}">
                {{-- <x-get-normal openBtn="Crear oferta" /> --}}
                <x-jet-button>Crear oferta</x-jet-button>
            </a>
        </div>

        <div class="scroll-containerChico mx-auto">
            @if ($offers->count())
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('discount')">Descuento</th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'discount')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('startDate')">Fecha de
                                inicio
                            </th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'startDate')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            <th class="cursor-pointer py-3 px-6 text-left" wire:click="order('endDate')">Fecha de fin
                            </th>
                            {{-- SORT ICON --}}
                            @if ($sort == 'endDate')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($offers as $offer)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span class="font-medium">{{ $offer->discount }}%</span>
                                        </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $offer->startDate }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $offer->endDate }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('offers.edit', $offer) }}">
                                            <x-button-normal openBtn="Editar" />
                                        </a>
                                        <div class="overflow-x-auto">
                                            <x-button openBtn="Eliminar" value="{{ $offer->id }}"></x-button>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-4">
                    No existen ofertas que coincidan.
                </div>
            @endif
        </div>
    </div>
</div>
