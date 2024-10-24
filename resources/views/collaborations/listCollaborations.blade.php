@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}

            <form class="input-group" action="/payments" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            {{-- Boton para agregar --}}

            <x-modal id="createCourses" title="Colaboraciòn" bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                <x-slot name="button">
                    Agregar
                    <x-iconos.agregar />
                </x-slot>

                <x-slot name="body">
                    @include('collaborations.createCollaborations')
                </x-slot>
            </x-modal>
        </div>


        {{-- Boton para la papelera --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/collaborations/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
        </div>

        {{-- Tabla de colaboraciones existentes --}}

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Nombre</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>
                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($collaborations as $collaboration)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$collaboration->name}") }}</x-tablas.td>
                        <x-tablas.td>

                            {{-- modal para desactivar una colaboraciòn --}}
                            <x-modal id="delete{{ Str::random(16) }}" title="Eliminar"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-600">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <p class="mt-5 mb-4 text-sm text-center">¿Está seguro de eliminar el curso de
                                        {{ $collaboration->name }}?</p>
                                    <form action="/collaborations/delete/{{ $collaboration->id }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-5 py-2 mt-1 text-sm font-bold bg-blue-700 rounded text-gray-50">
                                            Aceptar
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>

                            {{-- modal para editar una colaboracion --}}

                            <x-modal id="delete{{ Str::random(16) }}" title="Editar"
                                bstyle="border-none bg-orange-600 text-white hover:bg-orange-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/collaborations/edit/{{ $collaboration->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black mt-5"
                                                required value="{{ $collaboration->name }}" />
                                        </div>

                                        <button
                                            type="submit"class="px-5 py-2 mt-5 text-sm font-bold bg-blue-700 rounded text-gray-50">
                                            Aceptar
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>

                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>
        <div>
            {{ $collaborations->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
