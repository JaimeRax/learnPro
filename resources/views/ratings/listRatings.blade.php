@extends('layouts.base')



@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            <form method="GET" action="#" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" required
                    onchange="document.getElementById('degreeForm').submit()" />
            </form>
            <form method="GET" action="#" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="Seccion" name="degree_id" required
                    onchange="document.getElementById('degreeForm').submit()" />
            </form>
            <form method="GET" action="#" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="Curso" name="degree_id" required
                    onchange="document.getElementById('degreeForm').submit()" />
            </form>

            <x-button-link href="#" class="text-white bg-orange-600 mt-9">
                Buscar
            </x-button-link>
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
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($students as $studens)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad1" id="actividad1"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad2" id="actividad2"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="actividad3" id="actividad3"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento1" id="mejoramiento1"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento2" id="mejoramiento2"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="mejoramiento3" id="mejoramiento3"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="Disciplina" id="Disciplina"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="extracurricular" id="extracurricular"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" min="0" name="examen" id="examen"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required oninput="calculateFinalGrade()" />
                        </x-tablas.td>
                        <x-tablas.td>
                            <input type="number" readonly name="notaFinal" id="notaFinal"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                required />
                        </x-tablas.td>

                        <x-tablas.td>
                            <x-button href="student/viewForm" class="mt-2 btn-primary">

                                <x-iconos.guardar />

                            </x-button>


                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>


        </x-tablas.table>
        {{-- <div>
            {{ $rating->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div> --}}
    @endsection
    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script>
        function calculateFinalGrade() {
            // Obtener los valores de los inputs
            const actividad1 = parseFloat(document.getElementById('actividad1').value) || 0;
            const actividad2 = parseFloat(document.getElementById('actividad2').value) || 0;
            const actividad3 = parseFloat(document.getElementById('actividad3').value) || 0;
            const mejoramiento1 = parseFloat(document.getElementById('mejoramiento1').value) || 0;
            const mejoramiento2 = parseFloat(document.getElementById('mejoramiento2').value) || 0;
            const mejoramiento3 = parseFloat(document.getElementById('mejoramiento3').value) || 0;
            const disciplina = parseFloat(document.getElementById('Disciplina').value) || 0;

            const extracurricular = parseFloat(document.getElementById('extracurricular').value) || 0;
            const examen = parseFloat(document.getElementById('examen').value) || 0;

            // Calcular la nota final
            const notaFinal = actividad1 + actividad2 + actividad3 + mejoramiento1 + mejoramiento2 + mejoramiento3 +
                disciplina + extracurricular + examen;

            // Mostrar el resultado en el campo notaFinal
            document.getElementById('notaFinal').value = notaFinal;
        }
    </script>
