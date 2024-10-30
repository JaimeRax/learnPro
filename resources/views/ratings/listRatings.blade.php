@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">
        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">
            <form method="GET" action="/ratings" id="filtersForm" class="flex items-center mt-6 space-x-4">
                <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')" required />
                <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()" :selected="request('section_id')" required />
                <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()" :selected="request('course_id')" required />
                <x-button type="submit" class="text-white mt-9 bg-cyan-600">Buscar</x-button>
            </form>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Estudiante</x-tablas.th>
                    <x-tablas.th>Act #1</x-tablas.th>
                    <x-tablas.th>Act #2</x-tablas.th>
                    <x-tablas.th>Act #3</x-tablas.th>
                    <x-tablas.th>Mej #1</x-tablas.th>
                    <x-tablas.th>Mej #2</x-tablas.th>
                    <x-tablas.th>Mej #3</x-tablas.th>
                    <x-tablas.th>Disciplina</x-tablas.th>
                    <x-tablas.th>Extracurrilar</x-tablas.th>
                    <x-tablas.th>Examen</x-tablas.th>
                    <x-tablas.th>Nota Final</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>
                </x-tablas.tr>
            </x-slot>

            <x-slot name="tbody">
                @php
                    $i = 1;
                @endphp
                @foreach ($students as $studens)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad1" id="actividad1-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad2" id="actividad2-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad3" id="actividad3-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento1" id="mejoramiento1-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento2" id="mejoramiento2-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento3" id="mejoramiento3-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="Disciplina" id="Disciplina-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="extracurricular" id="extracurricular-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="examen" id="examen-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade({{ $studens->id }})" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" readonly name="notaFinal" id="notaFinal-{{ $studens->id }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required />
                        </x-tablas.td>
                        <x-tablas.td>
                            <x-button id="createPayment-{{ $studens->id }}" href="{{ url('ratings/pdf_generator', $studens->id) }}" class="mt-2 btn-primary">
                                <x-iconos.guardar />
                            </x-button>
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>
    </div>
@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script>
    function calculateFinalGrade(studentId) {
        // Obtener los valores de los inputs específicos del estudiante
        const actividad1 = parseFloat(document.getElementById(`actividad1-${studentId}`).value) || 0;
        const actividad2 = parseFloat(document.getElementById(`actividad2-${studentId}`).value) || 0;
        const actividad3 = parseFloat(document.getElementById(`actividad3-${studentId}`).value) || 0;
        const mejoramiento1 = parseFloat(document.getElementById(`mejoramiento1-${studentId}`).value) || 0;
        const mejoramiento2 = parseFloat(document.getElementById(`mejoramiento2-${studentId}`).value) || 0;
        const mejoramiento3 = parseFloat(document.getElementById(`mejoramiento3-${studentId}`).value) || 0;
        const disciplina = parseFloat(document.getElementById(`Disciplina-${studentId}`).value) || 0;
        const extracurricular = parseFloat(document.getElementById(`extracurricular-${studentId}`).value) || 0;
        const examen = parseFloat(document.getElementById(`examen-${studentId}`).value) || 0;

        // Realiza el cálculo de la nota final (aquí puedes ajustar el cálculo según tus necesidades)
        const finalGrade = actividad1 + actividad2 + actividad3 + mejoramiento1 + mejoramiento2 + mejoramiento3 + disciplina + extracurricular + examen;

        // Asigna la nota final al campo correspondiente
        document.getElementById(`notaFinal-${studentId}`).value = finalGrade.toFixed(2);
    }
</script>
