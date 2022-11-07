@extends('layouts.plantilla')
@section('title', 'Ofertas')
@section('titleH1', 'Listado de ofertas')
@section('content')
    <!-- component -->
    @livewire('show-offers', ['title' => 'Título de prueba'])
    <div
        class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
        <div class="w-full lg:w-5/6">
        </div>
        <x-modal title="Eliminar oferta" leftBtn="Eliminar" rightBtn="Cancelar" ref="offers.destroy" value=""
            id="idModal">
            <p>¿Está seguro de eliminar esta oferta?</p>
        </x-modal>
    </div>
    </div>
    </div>
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        openmodal.forEach(element => {
            const modal = document.getElementById('idRefDestroy');
            modal.href = ``;
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
