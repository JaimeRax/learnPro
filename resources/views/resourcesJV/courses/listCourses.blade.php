@extends('layouts.base')


@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="CURSOS" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/courses" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />
                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            {{-- boton para agregar --}}
            <x-modal id="createCourses" title="Curso" bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                <x-slot name="button">
                    AGREGAR
                    <x-iconos.agregar />
                </x-slot>
                <x-slot name="body">
                    @include('resourcesJV.courses.createCourses')
                </x-slot>
            </x-modal>
        </div>

        {{-- Boton para la papelera --}}
        <div class="flex justify-end col-md-2">
            <x-button-link href="/courses/trash" class="text-white bg-orange-600">
                <x-iconos.basurero /> PAPELERA
            </x-button-link>
        </div>


        {{-- tabla de cursos --}}
        <x-tablas.table wire:loading.remove id="table" data-name="listCourses">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>NO.</x-tablas.th>
                    <x-tablas.th>CURSOS</x-tablas.th>
                    <x-tablas.th>ACCIONES</x-tablas.th>
                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($courses as $course)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$course->name}") }}</x-tablas.td>
                        <x-tablas.td>

                            {{-- modal para desactivar un curso --}}
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
                                        ¿Está seguro de eliminar el curso de <strong>{{ $course->name }}</strong>?
                                    </p>
                                    <form action="/courses/delete/{{ $course->id }}" method="POST">
                                        @csrf
                                        <div class="text-left ">
                                            <x-buttonAcept/>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>

                            {{-- modal para editar un curso --}}
                            <x-modal id="delete{{ Str::random(16) }}" title="Editar"
                                bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>
                                <x-slot name="body">
                                    <form action="/courses/edit/{{ $course->id }}" method="POST">
                                        @csrf
                                        <div>
                                            <input type="text" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black mt-5 mb-8"
                                                required value="{{ $course->name }}" />
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

        {{-- paginacion --}}
        <div>
            {{ $courses->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    </div>

@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
