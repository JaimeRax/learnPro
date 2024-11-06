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
                    <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                        required />
                    <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                        :selected="request('section_id')" required />
                    <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()"
                        :selected="request('course_id')" required />
                    <x-button type="submit" class="text-white mt-9 bg-cyan-600">Buscar</x-button>
                </form>

            </div>



            <x-button-link href="activity/showNew" class="mt-11 btn-primary">

                <x-iconos.editar /> Agregar

            </x-button-link>

        </div>


        {{-- Boton para la papelera --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/activity/trash" class="text-white bg-green-600">
                <x-iconos.basurero /> Papelera
            </x-button-link>
        </div>


        {{-- INDICARDOR DE LOS PARAMETROS DE BUSQUEDA --}}

        <div>
            <div class="flex flex-wrap items-center justify-center gap-4 p-4 bg-white border rounded-lg">
                @if (request('degree_id') && ($degree = $degrees->find(request('degree_id'))))
                    <span
                        class="p-2 text-sm font-semibold text-gray-800 uppercase bg-gray-100 rounded">{{ $degree->name }}</span>
                @endif
                @if (request('section_id') && ($section = $sections->find(request('section_id'))))
                    <span
                        class="p-2 text-sm font-semibold text-gray-800 uppercase bg-gray-100 rounded">{{ $section->name }}</span>
                @endif
                @if (request('course_id') && ($course = $courses->find(request('course_id'))))
                    <span
                        class="p-2 text-sm font-semibold text-gray-800 uppercase bg-gray-100 rounded">{{ $course->name }}</span>
                @endif
            </div>
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

                            {{-- modal para desactivar un curso --}}
                            <x-modal id="delete{{ Str::random(16) }}" title="Eliminar"
                                bstyle="border-none bg-red-600 text-white hover:bg-red-600">
                                <x-slot name="button">
                                    <x-iconos.basurero />
                                </x-slot>

                                <x-slot name="body">
                                    <p class="mt-5 mb-4 text-sm text-center">¿Está seguro de eliminar la actividad
                                        {{ $activity->name }}?</p>
                                    <form action="/activity/delete/{{ $activity->id }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-5 py-2 mt-1 text-sm font-bold bg-blue-700 rounded text-gray-50">
                                            Aceptar
                                        </button>
                                    </form>
                                </x-slot>
                            </x-modal>

                            {{-- modal para editar un curso --}}

                            <x-modal id="createPayment-{{ $activity->id }}" title="Actividades"
                                bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.editar />
                                </x-slot>
                                <x-slot name="body">
                                    @include('activity.editActivity', [
                                        'activities' => $activities,
                                        'degrees' => $degrees,
                                        'sections' => $sections,
                                        'courses' => $courses
                                    ])
                                </x-slot>
                            </x-modal>
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
