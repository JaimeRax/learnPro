@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda --}}

            <form class="input-group" action="/courses" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            {{-- filtro por seleccion de grado --}}

            <form method="GET" action="/courses" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required onchange="document.getElementById('degreeForm').submit()" />
            </form>


            {{-- boton para agregar --}}

            <x-modal id="createCourses" title="Curso" bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                <x-slot name="button">
                    Agregar
                    <x-iconos.ver />
                </x-slot>

                <x-slot name="body">
                    @include('resourcesJV.courses.createCourses')
                </x-slot>
            </x-modal>

        </div>


        {{-- Boton para la papelera --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/courses/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
        </div>


        {{-- tabla de cursos --}}

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

                        {{-- modal para desactivar un curso --}}
                        <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja el Curso?"
                            bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                            <x-slot name="button">
                                <x-iconos.basurero />
                            </x-slot>

                            <x-slot name="body">
                                <form action="/courses/delete/{{ $course->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-error">
                                        Dar de Baja al Curso
                                    </button>
                                </form>
                            </x-slot>
                        </x-modal>

                        {{-- modal para editar un curso --}}

                        <x-modal id="delete{{ Str::random(16) }}" title="¿Desea editar el Curso?"
                            bstyle="border-none bg-orange-600 text-white hover:bg-orange-800">
                            <x-slot name="button">
                                <x-iconos.editar />
                            </x-slot>

                            <x-slot name="body">
                                <form action="/courses/edit/{{ $course->id }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Nombre
                                            del
                                            Curso</label>
                                        <input type="text" name="name" id="name"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                            required value="{{ $course->name }}" />
                                    </div>

                                    <button type="submit"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</button>

                                </form>
                            </x-slot>

                        </x-modal>
                    </x-tablas.td>
                </x-tablas.tr>
            @endforeach
        </x-slot>
        </x-tablas.table>

        {{-- paginacion --}}

        <div>
            {{ $courses->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
