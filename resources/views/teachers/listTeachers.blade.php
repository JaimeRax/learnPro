@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/student" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>


            {{-- filtro por seleccion de grado --}}

            {{-- <form method="GET" action="/student" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required onchange="document.getElementById('degreeForm').submit()" />
            </form> --}}


            {{-- BOTON PARA AGREGAR --}}

            {{-- <x-button-link href="student/viewForm" class="mt-2 btn-primary">

                <x-iconos.agregar /> Inscripciòn

            </x-button-link> --}}

        </div>

        <div class="flex justify-end col-md-2">
            <x-button-link href="/student/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Nombre del docente</x-tablas.th>
                    <x-tablas.th>DPI</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($users as $teacher)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$teacher->username} ") }}</x-tablas.td>
                        <x-tablas.td>2459455611890</x-tablas.td>
                        <x-tablas.td>

                                <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja al docente?"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/teachers/delete/{{ $teacher->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-error">
                                            Dar de Baja al docente
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>

                            <x-button-link href="teachers/showForm/{{ $teacher->id }}" class="mt-2 text-white bg-orange-500">

                                <x-iconos.editar />

                            </x-button-link>


                            <x-modal id="createPayment-{{ $teacher->id }}" title="Informacion" bstyle="border-none bg-purple-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.ver />
                                </x-slot>

                                <x-slot name="body">
                                    @include('teachers.infoTeachers', ['teacherId' => $teacher->id]) <!-- Aquí pasas el objeto usuario -->
                                </x-slot>
                            </x-modal>

                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach

            </x-slot>
            <div>
                {{ $users->appends(['search' => request()->query('search')])->links('components.pagination') }}
            </div>

        </x-tablas.table>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
