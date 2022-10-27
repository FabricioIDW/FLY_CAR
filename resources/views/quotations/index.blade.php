@extends('layouts.plantilla')
@section('title', 'Cotizacion')
@section('content')
    {{-- RESERVA --}}
    @if ($quotation->reserve)
        <p>Esta cotización posee una reserva.</p>
        <p>La reserva es válida hasta {{ $quotation->reserve->dateTimeExpiration }}</p>
    @else
        @php
            $values = ['action' => 'reserve', 'amount' => $reserve->amount];
        @endphp
        <x-modal-quotation openBtn="Reservar" title="Reserva" leftBtn="Realizar pago" rightBtn="Cancelar"
            ref="payments.index" :value=$values>
            <p>Importe de la cotización: ${{ $quotation->finalAmount }}</p>
            <p>Importe de la seña a pagar: ${{ $reserve->amount }}</p>
            <p>(5% del importe de la cotización)</p>
        </x-modal-quotation>
    @endif
    {{-- VENTA --}}
    @if ($quotation->reserve && !$quotation->checkVehiclesState())
        @php
            $values = ['action' => 'cancelateReserve', 'amount' => $quotation->reserve->amount];
        @endphp
        <p>Alguno de los vehículos de la cotización sufrio un sinientro. Se debe cancelar la reserva.</p>
        <x-modal-quotation openBtn="Cancelar reserva" title="Cancelar reserva" leftBtn="Realizar pago" rightBtn="Cancelar"
            ref="payments.index" :value=$values>
            <p>Cancelar la reserva.</p>
        </x-modal-quotation>
    @else
        @if (!$quotation->checkVehiclesState())
            <p>No se puede realizar la venta ya que alguno de los vehículos de la cotización sufrio un sinientro.</p>
        @else
            @php
                $amount = $quotation->reserve ? $quotation->finalAmount - $quotation->reserve->amount : $quotation->finalAmount;
                $values = ['action' => 'sale', 'amount' => $amount];
            @endphp
            <x-modal-quotation openBtn="Realizar venta" title="Venta" leftBtn="Realizar pago" rightBtn="Cancelar"
                ref="payments.index" :value=$values>
                <p>Monto a pagar: ${{ $amount }}</p>
            </x-modal-quotation>
        @endif
    @endif
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        openmodal.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                toggleModal();
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
