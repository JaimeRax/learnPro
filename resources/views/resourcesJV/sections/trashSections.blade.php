@extends('layouts.base')


@section('header')
    <x-route route="/" previousRouteName="Inicio" currentRouteName="Secciones Eliminadas" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            <form class="input-group" action="/sections/trash" method="get">
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
            <x-button-link href="/sections" class="mt-2 text-white bg-orange-400">

                <x-iconos.volver /> Volver

            </x-button-link>
        </div>


        <x-tablas.table wire:loading.remove id="table" data-name="listSectionDelete">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>NO.</x-tablas.th>
                    <x-tablas.th>SECCIONES</x-tablas.th>
                    <x-tablas.th>ACCIONES</x-tablas.th>
                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($sections as $section)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$section->name }")}}</x-tablas.td>
                         <x-tablas.td>
                            {{-- modal para restaurar una sección --}}
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
                                        ¿Está seguro de restaurar la sección <strong>{{ $section->name }}</strong>?
                                    </p>
                                    <form action="/sections/restore/{{ $section->id }}" method="POST">
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
        <div>
            {{ $sections->links('components.pagination') }}
        </div>
    </div>
@endsection
