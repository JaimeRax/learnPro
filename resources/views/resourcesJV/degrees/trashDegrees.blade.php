@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            <form class="input-group" action="/degrees" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>


            {{-- @php

                $listaregistros = array_map(function ($tipo) {
                    return ucwords(strtolower($tipo));
                }, Constantes::LISTAR_REGISTROS);

            @endphp --}}

            <!-- Llamada al componente del modal -->
            <x-modal id="createDegrees" title="Grado" bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                <x-slot name="button">
                    Agregar

                    <x-iconos.ver />

                </x-slot>

                <x-slot name="body">

                    @include('resourcesJV.degrees.createDegrees')

                </x-slot>
            </x-modal>

            {{-- <x-reporte-fecha titulo="Reporte Cliente" titleButton="Reporte Cliente" />  --}}

        </div>



        <div wire:loading.block wire:target='valor,porPagina,gotoPage'>

            {{-- <x-line-loader /> --}}

        </div>



        {{-- <ul class="flex flex-wrap gap-2 my-2 font-medium text-center text-gray-500 text-md">

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
                    <x-tablas.th>Grado</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($degree as $degrees)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ $degrees->name }}</x-tablas.td>
                        <x-tablas.td>
                            <form action="/degrees/restore/{{ $degrees->id }}" method="POST">

                                @csrf

                                {{ @method_field('POST') }}

                                <input type="submit"
                                    class="w-40 px-2 py-1 text-sm text-white bg-green-400 border-none rounded-lg btn-xs"
                                    value="Restaurar"
                                    onclick="return confirm('¿Está completamente seguro de querer restaurar este grado?')">

                            </form>
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach

            </x-slot>


        </x-tablas.table>
        <div>
            {{ $degree->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    </div>
@endsection
