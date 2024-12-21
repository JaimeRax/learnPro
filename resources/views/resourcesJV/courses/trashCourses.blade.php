@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="CURSOS ELIMINADOS" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro de busqueda por nombre --}}
            <form class="input-group" action="/courses/trash" method="get">
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
            <x-button-link href="/courses" class="mt-2 text-white bg-orange-400">
                <x-iconos.volver /> VOLVER
            </x-button-link>
        </div>


        {{-- tabla de cursos desactivados --}}
        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
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
                            {{-- modal para activar curso --}}
                            <x-modal id="delete{{ Str::random(16) }}" title="Restaurar"
                                bstyle="border-none bg-yellow-400 text-white hover:bg-yellow-600">
                                <x-slot name="button">
                                    restaurar
                                </x-slot>
                                <x-slot name="body">
                                    <p class="text-sm text-center mt-5 mb-8">
                                        <span class="text-yellow-500 text-lg mr-2">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        ¿Está seguro de restaurar el curso de <strong>{{ $course->name }}</strong>?
                                    </p>
                                    <form action="/courses/restore/{{ $course->id }}" method="POST">
                                        @csrf
                                        <div class="text-left ">
                                            <x-buttonAcept />
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
