@extends('layouts.plantilla')
@section('title', 'Buscar cotización')
@section('titleH1', 'Buscar cotización')

@section('content')
<div class="content-center px-12 mx-12 col-span-6">
     @livewire('quotation-search')
    </div>
@endsection
