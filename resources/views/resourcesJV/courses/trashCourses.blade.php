@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            <x-inputs.general id="busqueda-cliente" placeholder="Busque por cualquier campo..."
                wire:model.live.debounce.500ms='valor' />

            {{-- @php

                $listaregistros = array_map(function ($tipo) {
                    return ucwords(strtolower($tipo));
                }, Constantes::LISTAR_REGISTROS);

            @endphp --}}

            <x-inputs.select-option id="por-pagina" wire:model.live='porPagina' :required="true" />




            {{-- <x-reporte-fecha titulo="Reporte Cliente" titleButton="Reporte Cliente" /> --}}

        </div>



        <div wire:loading.block wire:target='valor,porPagina,gotoPage'>

            {{-- <x-line-loader /> --}}

        </div>


{{--
        <ul class="flex flex-wrap gap-2 my-2 font-medium text-center text-gray-500 text-md">

            <li class="me-2">

                <button wire:click.prevent="setSearchType('active')" @class([
                    'btn-success' => $searchType === 'active'
                ])>

                    Activos

                </button>

            </li>

            <li class="me-2">

                <button wire:click.prevent="setSearchType('trash')" @class([
                    'btn-success' => $searchType === 'trash'
                ])>

                    Inactivos

                </button>

            </li>
        </ul> --}}

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Cursos</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($courses as $course)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ $course->name }}</x-tablas.td>
                        <x-tablas.td>
                            <form action="/courses/restore/{{ $course->id }}" method="POST">
                                @csrf
                                {{ @method_field('POST') }}
                                <input type="submit"
                                    class="w-40 px-2 py-1 text-sm text-white bg-green-400 border-none rounded-lg btn-xs"
                                    value="Restaurar"
                                    onclick="return confirm('¿Está completamente seguro de querer restaurar esta curso?')">
                            </form>
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>
        <div>
            {{ $courses->links('components.pagination') }}
        </div>
    </div>
@endsection
