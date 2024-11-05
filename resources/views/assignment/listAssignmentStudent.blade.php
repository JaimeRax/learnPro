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
                    <x-tablas.th>Nombre del estudiante</x-tablas.th>
                    <x-tablas.th>Codigo Estudiantil</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>

                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($students as $student)
                <x-tablas.tr>
                    <x-tablas.td>{{ $i++ }}</x-tablas.td>
                    <x-tablas.td>{{ strtoupper("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}") }}</x-tablas.td>
                    <x-tablas.td>{{ $student->personal_code }}</x-tablas.td>
                    <x-tablas.td>
                        <x-modal title="Asignación" id="asignacion-{{ $student->id }}" bstyle="border-none bg-orange-600 text-white hover:bg-orange-800">
                            <x-slot name="button">
                                <x-iconos.asignar data-modal-target="#asignacion-{{ $student->id }}" />
                            </x-slot>

                            <x-slot name="body">
                                <form class="space-y-4" action="{{ url('/assignment/newAssignmentStudent/' . $student->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                                    <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
                                        <label><b>Año Escolar: </b></label>
                                        <x-inputs.general id="year" name="year" readonly style="text-align: center; font-weight: bold;" value="{{ \Carbon\Carbon::now()->format('Y') }}" required />
                                    </div>

                                    <x-inputs.select-option id="degrees_id" titulo="Grado" name="degrees_id" :options="$degrees->pluck('name', 'id')->toArray()" required />
                                    <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()" required />

                                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Agregar
                                    </button>
                                </form>
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
