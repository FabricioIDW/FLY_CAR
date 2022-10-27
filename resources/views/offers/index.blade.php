@extends('layouts.plantilla')
@section('title', 'Ofertas')
@section('content')
    <h1>Listado de ofertas</h1>
    <!-- component -->
    <div
        class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
        <div class="w-full lg:w-5/6">
            <div class="bg-white shadow-md rounded my-6">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Descuento</th>
                            <th class="py-3 px-6 text-left">Fecha de inicio</th>
                            <th class="py-3 px-6 text-left">Fecha de fin</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($offers as $offer)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
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
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </a>
                                        <div class="overflow-x-auto">
                                            <x-button openBtn="Eliminar" value="{{ $offer->id }}"></x-button>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $offers->links() }}
            </div>
            <x-modal  title="Eliminar oferta" leftBtn="Eliminar" rightBtn="Cancelar" ref="offers.destroy"
                value="" id="idModal">
                <p>¿Está seguro de eliminar esta oferta?</p>
            </x-modal>
        </div>
    </div>
    </div>
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        openmodal.forEach(element => {
            const modal = document.getElementById('idRefDestroy');
            element.addEventListener('click', function(event) {
                event.preventDefault();
                toggleModal();
                console.log(element.value);
                modal.href = `ofertas/${element.value}`;
            });
        });

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
            closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
                isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                toggleModal()
            }
        };

        function toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    </script>

@endsection
