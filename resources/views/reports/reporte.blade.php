@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', $title)

@section('content')
    @if (count($queryBuilder) > 0)
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    @php
                        foreach ($queryBuilder[0] as $key => $value) {
                            echo '<th class="py-3 px-6 text-left">' . $key . '</th>';
                        }
                    @endphp
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($queryBuilder as $element)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        @php
                            foreach ($element as $key => $value) {
                                echo 
                                '<td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span class="font-medium">' . $value . '</span>
                                        </div>
                                </td>';
                            }
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron resultados para este reporte</p>
    @endif

@endsection
