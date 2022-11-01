@extends('layouts.plantilla')
@extends('layouts.partials.contenedorMiCotizacion')
@section('title', 'Buscar Cotizacion')

@section('contend')
    <div class="col-span-6">
        <div class="w-full h-8 pt-2 pl-8 col-span-1 lg:col-span-1">
            <a href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-house-door" viewBox="0 0 16 16">
                    <path
                        d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
                </svg>
            </a>
        </div>
        <h1 class="text-center text-3xl font-extrabold hover:animate-pulse">Buscar Cotizacion</h1>
    </div>
    <div class="content-center px-12 mx-12 col-span-6">
        @livewire('quotation-search')
    </div>
@endsection
