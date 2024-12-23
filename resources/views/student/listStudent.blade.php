@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="ESTUDIANTES" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/student" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-14" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>


            {{-- filtro por seleccion de grado --}}
            <form method="GET" action="/student" id="degreeForm" class="flex items-center mt-6 space-x-4">
                <!-- Selector de Grado -->
                <x-inputs.select-option id="degree_id" titulo="GRADO" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required />

                <!-- Selector de Sección -->
                <x-inputs.select-option id="section_id" titulo="SECCIÓN" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                    :selected="request('section_id')" required />

                <!-- Botón de Búsqueda -->
                <x-button type="submit" class="text-white mt-9 bg-green-600">
                    <x-iconos.buscar />
                    BUSCAR
                </x-button>
            </form>

            {{-- BOTON PARA AGREGAR --}}
            <x-button-link href="student/viewForm" class="mt-11 btn-primary">
                <x-iconos.agregar /> AGREGAR
            </x-button-link>

        </div>

        <div class="flex justify-end col-md-2">
            <x-button-link href="/student/trash" class="text-white bg-orange-600">
                <x-iconos.basurero /> PAPELERA
            </x-button-link>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="listStudent">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>NO.</x-tablas.th>
                    <x-tablas.th>NOMBRE</x-tablas.th>
                    <x-tablas.th>CÓDIGO ESTUDIANTIL</x-tablas.th>
                    <x-tablas.th>GRADO</x-tablas.th>
                    <x-tablas.th>SECCIÓN</x-tablas.th>
                    <x-tablas.th>ACCIONES</x-tablas.th>
                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($students as $studens)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>{{ $studens->personal_code }}</x-tablas.td>
                        <x-tablas.td>{{ $studens->degree_name }}</x-tablas.td>
                        <x-tablas.td>{{ $studens->section_name }}</x-tablas.td>
                        <x-tablas.td>
                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja al estudiante?"
                                bstyle="border-none bg-yellow-400 text-white hover:bg-yellow-800">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>
                                <x-slot name="body">
                                    <form action="/student/delete/{{ $studens->id }}" method="POST">
                                        @csrf
                                        <x-buttonAcept />
                                    </form>
                                    <x-alert-message />
                                </x-slot>
                            </x-modal>

                            <x-button-link href="/student/formEdit/{{ $studens->id }}" class="mt-2 text-white bg-blue-600">
                                <x-iconos.editar />
                            </x-button-link>

                            <x-modal id="createPayment-{{ $studens->id }}" title="Informacion"
                                bstyle="border-none bg-purple-600 text-white hover:bg-purple-800">
                                <x-slot name="button">
                                    <x-iconos.ver />
                                </x-slot>
                                <x-slot name="body">
                                    @include('student.infoStudent', ['studentId' => $studens->id]) <!-- Aquí pasas el objeto usuario -->
                                </x-slot>
                            </x-modal>

                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>

        </x-tablas.table>
        <div>
            {{ $students->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
