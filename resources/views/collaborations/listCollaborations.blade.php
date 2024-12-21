@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="COLABORACIONES" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}

            <form class="input-group" action="/collaborations" method="get">
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
                    AGREGAR
                    <x-iconos.agregar />
                </x-slot>

                <x-slot name="body">
                    @include('collaborations.createCollaborations')
                </x-slot>
            </x-modal>
        </div>


        {{-- Boton para la papelera --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/collaborations/trash" class="text-white bg-orange-600">
                <x-iconos.basurero /> PAPELERA
            </x-button-link>
        </div>

        {{-- Tabla de colaboraciones existentes --}}

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>NO.</x-tablas.th>
                    <x-tablas.th>COLABORACIÓN</x-tablas.th>
                    <x-tablas.th>ACCIONES</x-tablas.th>
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
                                bstyle="border-none bg-yellow-400 text-white hover:bg-yellow-600">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <p class="text-sm text-center mt-5 mb-8">
                                        <span class="text-yellow-500 text-lg mr-2">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        ¿Está seguro de eliminar la colaboración <strong>{{ $collaboration->name }}</strong>?
                                    </p>
                                    <form action="/collaborations/delete/{{ $collaboration->id }}" method="POST">
                                        @csrf
                                        <div class="text-left ">
                                            <x-buttonAcept/>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>

                            {{-- modal para editar una colaboracion --}}

                            <x-modal id="delete{{ Str::random(16) }}" title="Editar"
                                bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/collaborations/edit/{{ $collaboration->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black mt-5 mb-8"
                                                required value="{{ $collaboration->name }}" />
                                        </div>

                                        <div class="text-left ">
                                            <x-buttonAcept/>
                                        </div>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
