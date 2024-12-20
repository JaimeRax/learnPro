@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="Inicio" currentRouteName="Secciones" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">
            <form class="input-group" action="/sections" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />
                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            <x-modal id="createSections" title="Sección" bstyle="border-none bg-green-600 text-white hover:bg-green-800">
                <x-slot name="button">
                    Agregar
                    <x-iconos.agregar />
                </x-slot>
                <x-slot name="body">
                    @include('resourcesJV.sections.createSections')
                </x-slot>
            </x-modal>
        </div>

        <div class="flex justify-end col-md-2">
            <x-button-link href="/sections/trash" class="text-white bg-orange-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr class="mt-4">
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
                        <x-tablas.td>{{ strtoupper("{$section->name}") }}</x-tablas.td>
                        <x-tablas.td>
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
                                        ¿Está seguro de eliminar la sección <strong>{{ $section->name }}</strong>?
                                    </p>
                                    <form action="/sections/delete/{{ $section->id }}" method="POST">
                                        @csrf
                                        <div class="text-left ">
                                            <button type="submit"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Aceptar
                                            </button>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>

                            {{-- modal para editar un seccion --}}
                            <x-modal id="delete{{ Str::random(16) }}" title="Editar"
                                bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/sections/edit/{{ $section->id }}" method="POST">
                                        @csrf
                                        <div>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black mt-5 mb-8"
                                                oninput="this.value = this.value.toUpperCase();" maxlength="1"
                                                required value="{{ $section->name }}" />
                                        </div>

                                        <div class="text-left ">
                                            <button type="submit"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Aceptar
                                            </button>
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
            {{ $sections->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    </div>
@endsection
<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
