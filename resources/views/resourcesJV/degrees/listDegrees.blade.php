@extends('layouts.base')



@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
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
        <div class="flex justify-end col-md-2">
            <x-button-link href="/degrees/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
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
                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja al Grado?"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/degrees/delete/{{ $degrees->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-error">
                                            Dar de Baja al Grado
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>
                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea editar el Grado?"
                                bstyle="border-none bg-orange-600 text-white hover:bg-orange-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/degrees/edit/{{ $degrees->id }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900">Nombre del
                                                Grado</label>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                                required value="{{ $degrees->name }}" />
                                        </div>

                                        <button type="submit"
                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>

                                    </form>
                                </x-slot>
                            </x-modal>

                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach

            </x-slot>


        </x-tablas.table>
        <div>
            {{ $degree->links('components.pagination') }}
        </div>
    </div>
@endsection
