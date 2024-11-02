@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}

            <form class="input-group" action="/collaborations/trash" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

        </div>

        {{-- BOTON PARA VOLVER --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/collaborations" class="mt-2 text-white bg-orange-400">

                <x-iconos.volver /> Volver

            </x-button-link>
        </div>


        {{-- Tabla para colaboraciones eliminadas --}}

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

                            {{-- modal para restaurar un curso --}}
                            <form action="/collaborations/restore/{{ $collaboration->id }}" method="POST">
                                @csrf
                                {{ @method_field('POST') }}
                                <input type="submit"
                                    class="w-40 px-2 py-1 text-sm text-white bg-green-400 border-none rounded-lg btn-xs"
                                    value="Restaurar"
                                    onclick="return confirm('¿Está completamente seguro de querer restaurar esta colaboraciòn?')">
                            </form>
                            <x-alert-message />

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
