@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro de busqueda por nombre --}}
            <x-inputs.general id="busqueda-cliente" placeholder="Busque por cualquier campo..."
                wire:model.live.debounce.500ms='valor' />


            {{-- filtro de seleccion por grado --}}
            <x-inputs.select-option id="por-pagina" wire:model.live='porPagina' :required="true" />

        </div>

        {{-- tabla de cursos desactivados --}}

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

                            {{-- modal para restaurar un curso --}}
                            <form action="/courses/restore/{{ $course->id }}" method="POST">
                                @csrf
                                {{ @method_field('POST') }}
                                <input type="submit"
                                    class="w-40 px-2 py-1 text-sm text-white bg-green-400 border-none rounded-lg btn-xs"
                                    value="Restaurar"
                                    onclick="return confirm('¿Está completamente seguro de querer restaurar esta curso?')">
                            </form>

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
