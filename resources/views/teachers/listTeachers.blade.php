@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

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

            <x-button-link href="users/viewForm" class="mt-2 btn-primary">

                <x-iconos.agregar /> Agregar

            </x-button-link>

        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Nombre</x-tablas.th>
                    <x-tablas.th>DPI</x-tablas.th>
                    <x-tablas.th>Correo Electrònico</x-tablas.th>
                    <x-tablas.th>Telèfono</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($users as $user)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$user->first_name} {$user->second_name} {$user->first_lastname} {$user->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>{{ $user->dpi }}</x-tablas.td>
                        <x-tablas.td>{{ $user->email }}</x-tablas.td>
                        <x-tablas.td>{{ $user->phone }}</x-tablas.td>
                        <x-tablas.td>

                            <x-modal id="createPayment-{{ $user->id }}" title="Informacion"
                                bstyle="border-none bg-purple-600 text-white hover:bg-purple-800">
                                <x-slot name="button">
                                    <x-iconos.ver />
                                </x-slot>

                                <x-slot name="body">
                                    @include('teachers.infoCoursesAssignment', ['teacherId' => $user->id]) <!-- Aquí pasas el objeto usuario -->
                                </x-slot>
                            </x-modal>

                            <x-button-link href="{{ url('assignment/form/' . $user->id) }}" class="mt-2 btn-primary">
                                <x-iconos.asignar />
                            </x-button-link>
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
                <x-alert-message />

            </x-slot>
            <div>
                {{ $users->appends(['search' => request()->query('search')])->links('components.pagination') }}
            </div>

        </x-tablas.table>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
