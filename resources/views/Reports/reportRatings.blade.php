

@extends('layouts.base')



@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection



@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="container mx-auto">
            <h1 class="mb-4 text-xl font-bold">Generar Reporte de Calificaciones</h1>

            <form method="GET" action="{{ url('ratings/generateRatingsPDF') }}" id="pdfForm">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="grado" class="block text-sm font-medium text-gray-700">Grado</label>
                        <select id="grado" name="grado" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un grado</option>
                            @foreach ($degree as $grado)
                                <option value="{{ $grado->id }}">{{ $grado->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="seccion" class="block text-sm font-medium text-gray-700">Sección</label>
                        <select id="seccion" name="seccion" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione una sección</option>
                            @foreach ($section as $seccion)
                                <option value="{{ $seccion->id }}">{{ $seccion->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="curso" class="block text-sm font-medium text-gray-700">Curso</label>
                        <select id="curso" name="curso" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un curso</option>
                            @foreach ($course as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-button type="submit" class="text-white bg-blue-600">Generar PDF</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
