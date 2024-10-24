@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/users" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>


            {{-- filtro por seleccion de grado --}}

            <form method="GET" action="/users" id="userSearchForm" class="mt-6">
                <x-inputs.select-option id="role_id" titulo="" name="role_id" :options="$roles->pluck('name', 'id')->toArray()" :selected="request('role_id')"
                    required onchange="document.getElementById('userSearchForm').submit()" />


            </form>



            {{-- BOTON PARA AGREGAR --}}

            <x-button-link href="users/viewForm" class="mt-2 btn-primary">

                <x-iconos.agregar /> Agregar

            </x-button-link>

        </div>

        <div class="flex justify-end col-md-2">
            <x-button-link href="/users/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
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
                    <x-tablas.th>Rol</x-tablas.th>
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

                            @forelse ($user->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @empty
                                <span class="badge badge-danger">No roles</span>
                            @endforelse
                        </x-tablas.td>
                        <x-tablas.td>

                            <x-modal id="delete{{ Str::random(16) }}" title="¿Desea dar de baja al usuario?"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <form action="/users/delete/{{ $user->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-error">
                                            Dar de Baja al usuario
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>

                            <x-button-link href="/users/showForm/{{ $user->id }}" class="mt-2 text-white bg-orange-500">

                                <x-iconos.editar />

                            </x-button-link>


                            <x-modal id="createPayment-{{ $user->id }}" title="Informacion"
                                bstyle="border-none bg-purple-600 text-white hover:bg-purple-800">
                                <x-slot name="button">
                                    <x-iconos.ver />
                                </x-slot>

                                <x-slot name="body">
                                    @include('user.infoUsers', ['teacherId' => $user->id]) <!-- Aquí pasas el objeto usuario -->
                                </x-slot>
                            </x-modal>


                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach

            </x-slot>


            <x-alert-message />
        </x-tablas.table>
        <div>
            {{ $users->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
