@extends('layouts.plantilla')
@section('title', 'Accesorios')
@section('titleH1', 'Accesorios')

@section('content')
    @livewire('show-accesories')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        openmodal.forEach(element => {
            const modal = document.getElementById('idRefDestroy');
            element.addEventListener('click', function(event) {
                event.preventDefault();
                toggleModal();
                console.log(element.value);
                modal.href = `eliminarAccesorio/${element.value}`;
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
    {{-- Termina div content --}}
    <div class="text-center">@include('layouts.partials.footer')</div>
@endsection
