

@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="container mx-auto">
            <h1 class="mb-4 text-xl font-bold">Generar Reporte de Calificaciones</h1>

            <form method="GET" action="{{ url('ratings/generateRatingsPDF') }}" id="pdfForm" class="flex items-center mt-6 space-x-4">
                <!-- Selector de Grado -->
                <x-inputs.select-option id="grado" titulo="Grado" name="grado"
                    :options="$degree->pluck('name', 'id')->toArray()"
                    :selected="request('grado')"
                    placeholder="Seleccione un grado" />

                <!-- Selector de Sección -->
                <x-inputs.select-option id="seccion" titulo="Sección" name="seccion"
                    :options="$section->pluck('name', 'id')->toArray()"
                    :selected="request('seccion')"
                    placeholder="Seleccione una sección" />

                <!-- Selector de Curso -->
                <x-inputs.select-option id="curso" titulo="Curso" name="curso"
                    :options="$course->pluck('name', 'id')->toArray()"
                    :selected="request('curso')"
                    placeholder="Seleccione un curso" />

                <!-- Botón de Generar PDF -->
                <x-button type="submit" class="text-white mt-9 bg-blue-600">
                    Generar PDF
                </x-button>
            </form>


        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
