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


            <!-- Llamada al componente del modal -->
            <x-modal id="createSections" title="Grado" bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                <x-slot name="button">
                    Agregar

                    <x-iconos.ver />

                </x-slot>

                <x-slot name="body">

                    @include('resourcesJV.sections.createSections')

                </x-slot>
            </x-modal>



            {{-- <x-reporte-fecha titulo="Reporte Cliente" titleButton="Reporte Cliente" /> --}}

        </div>



        <div wire:loading.block wire:target='valor,porPagina,gotoPage'>

            {{-- <x-line-loader /> --}}

        </div>



        <ul class="flex flex-wrap gap-2 my-2 font-medium text-center text-gray-500 text-md">

            <li class="me-2">

                {{-- <button wire:click.prevent="setSearchType('active')" @class([
                    'btn-success' => $searchType === 'active'
                ])>

                    Activos

                </button> --}}

                <button wire:click.prevent="setSearchType('active')" @class([])>

                    Activos

                </button>

            </li>

            <li class="me-2">

                <button wire:click.prevent="setSearchType('trash')" @class([
                    // 'btn-success' => $searchType === 'trash'
                ])>

                    Inactivos

                </button>

            </li>
        </ul>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Secciones</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">

                @foreach ($sections as $section)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ $section->name }}</x-tablas.td>
                        <x-tablas.td>
                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja a la Seccions?"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/sections/delete/{{ $section->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-error">
                                            Dar de Baja a la Seccion
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>
                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea editar la Seccion?"
                                bstyle="border-none bg-orange-600 text-white hover:bg-orange-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/sections/edit/{{ $section->id }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900">Nombre de la
                                                Seccion</label>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                                required value="{{ $section->name }}" />
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


        {{-- <div>

            {{ $clientes->links('components.pagination') }}

        </div> --}}

    </div>
@endsection
