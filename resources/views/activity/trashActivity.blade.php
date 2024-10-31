@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

                {{-- filtro por busqueda de nombre --}}
                <form method="GET" action="/activity" id="filtersForm" class="flex items-center mt-6 space-x-4">
                    <!-- Selector de Grado -->
                    <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                        required />

                    <!-- Selector de Sección -->
                    <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                        :selected="request('section_id')" required />

                    <!-- Selector de Curso -->
                    <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()"
                        :selected="request('course_id')" required />

                    <!-- Botón de Búsqueda -->
                    <x-button type="submit" class="text-white mt-9 bg-cyan-600">
                        Buscar
                    </x-button>
                </form>


            </div>

        </div>

        <div class="flex justify-end col-md-2">
            <x-button-link href="/activity" class="mt-2 text-white bg-orange-400">

                <x-iconos.volver /> Volver

            </x-button-link>
        </div>


        {{-- tabla de cursos --}}

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">

            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Actividad</x-tablas.th>
                    <x-tablas.th>Punteo</x-tablas.th>
                    <x-tablas.th>Fecha de entrega</x-tablas.th>
                    <x-tablas.th>Bimestre</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($activities as $activity)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ $activity->name }}</x-tablas.td>
                        <x-tablas.td>{{ $activity->plucking }}</x-tablas.td>
                        <x-tablas.td>{{ $activity->date_entity }}</x-tablas.td>
                        <x-tablas.td>{{ $activity->bimester }}</x-tablas.td>
                        <x-tablas.td>

                            {{-- modal para restaurar un curso --}}
                            <form action="/activity/restore/{{ $activity->id }}" method="POST">
                                @csrf
                                {{ @method_field('POST') }}
                                <input type="submit"
                                    class="w-40 px-2 py-1 text-sm text-white bg-green-400 border-none rounded-lg btn-xs"
                                    value="Restaurar"
                                    onclick="return confirm('¿Está completamente seguro de querer restaurar esta actividad?')">
                            </form>

                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>

        {{-- paginacion --}}

        <div>
            {{ $activities->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
