@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Administrador')

@section('content')
    <div class="content">

        <div class="grid grid-cols-4">
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Productos</div><br>

                <a href="{{ route('productos.create') }}">
                    <x-button-normal openBtn="Crear producto"></x-button-normal>
                </a>
                <br>
                <a href="{{ route('vehiculos.buscar') }}">
                    <x-button-normal openBtn="Buscar vehículos"></x-button-normal>
                </a>
                <a href="{{ route('accesorios.buscar') }}">
                    <x-button-normal openBtn="Buscar accesorios"></x-button-normal>
                </a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Ofertas</div><br>

                <a href="{{ route('offers.index') }}">
                    <x-button-normal openBtn="Ver ofertas"></x-button-normal>
                </a>
                <a href="{{ route('offers.create') }}">
                    <x-button-normal openBtn="Crear oferta"></x-button-normal>
                </a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Estadísticas</div><br>
                <x-button value="{{ route('estadisticas.comisionesMensuales') }}" openBtn="Comisiones mensuales"></x-button>
                <br>
                <x-button value="{{ route('estadisticas.modelosMasVendidos') }}" openBtn="Modelos más vendidos"></x-button>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Reportes</div><br>
                <x-button value="{{ route('reportes.accesoriosMasSolicitados') }}" openBtn="Accesorios más solicitados">
                </x-button>
                <br>
                <x-button value="{{ route('reportes.ventasNoConcretadas') }}" openBtn="Ventas no concretadas"></x-button>
                <br>
                {{-- vehiculosMasCotizados --}}
                <x-button value="{{ route('reportes.vehiculosMasCotizados') }}" openBtn="Vehículos más cotizados">
                </x-button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <div
                class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                    </path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>

            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Generar reporte</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                {{-- Formulario --}}
                <form action="" id="idForm" method="POST">
                    @csrf
                    <x-jet-label value="Fecha de inicio" />
                    <x-jet-input type="date" class="w-full" name="startDate" required
                        max="{{ now()->toDateString('Y-m-d') }}" />
                    <x-jet-label value="Fecha de fin" />
                    <x-jet-input type="date" class="w-full" name="endDate" required />
                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">
                            Generar reporte
                        </button>
                        <button type="button"
                            class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        const form = document.getElementById('idForm');
        openmodal.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                toggleModal();
                console.log(element.value);
                form.action = element.value;
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
