@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">
        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">
            <form method="GET" action="/ratings" id="filtersForm" class="flex items-center mt-6 space-x-4">
                <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required />
                <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                    :selected="request('section_id')" required />
                <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()" :selected="request('course_id')"
                    required />
                <x-button type="submit" class="text-white mt-9 bg-cyan-600">Buscar</x-button>
            </form>
        </div>

        <form method="POST" action="{{ route('ratings.update') }}">
            @csrf
            @method('POST')

            <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
                <x-slot name="thead">
                    <x-tablas.tr>
                        <x-tablas.th>No.</x-tablas.th>
                        <x-tablas.th>Estudiante</x-tablas.th>

                        @foreach ($activities as $activity)
                            <x-tablas.th>{{ $activity->name }}</x-tablas.th>
                        @endforeach

                        <x-tablas.th>Nota Final</x-tablas.th>
                        <x-tablas.th>Acciones</x-tablas.th>
                    </x-tablas.tr>
                </x-slot>

                <x-slot name="tbody">
                    @php $i = 1; @endphp
                    @foreach ($students as $student)
                        <x-tablas.tr>
                            <x-tablas.td>{{ $i++ }}</x-tablas.td>
                            <x-tablas.td>{{ strtoupper("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}") }}</x-tablas.td>

                            @foreach ($activities as $activity)
                                <x-tablas.td>
                                    <input type="number" min="0"
                                        name="ratings[{{ $student->id }}][{{ $activity->id }}][score_obtained]"
                                        id="rating_{{ $student->id }}_{{ $activity->id }}"
                                        value="{{ $ratings[$student->id][$activity->id]->score_obtained ?? '' }}"
                                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                        oninput="calculateFinalGrade({{ $student->id }})" />
                                </x-tablas.td>
                            @endforeach

                            <x-tablas.td>
                                <input type="number" readonly name="notaFinal" id="notaFinal-{{ $student->id }}"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                                    required />
                            </x-tablas.td>
                            <x-tablas.td>
                                <x-button id="createPayment-{{ $student->id }}"
                                    href="{{ url('ratings/pdf_generator', $student->id) }}" class="mt-2 btn-primary">
                                    <x-iconos.editar />
                                </x-button>
                            </x-tablas.td>
                        </x-tablas.tr>
                    @endforeach



                </x-slot>
            </x-tablas.table>

            <div class="flex justify-end mt-4">
                <x-button type="submit" class="text-white bg-blue-600">Guardar Calificaciones</x-button>
            </div>
        </form>
    </div>
@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Llamar a calculateFinalGrade para cada estudiante
        @foreach ($students as $student)
            calculateFinalGrade({{ $student->id }});
        @endforeach
    });


    function calculateFinalGrade(studentId) {
        // Obtener todos los inputs de las calificaciones para el estudiante específico
        const inputs = document.querySelectorAll(`input[name^="ratings[${studentId}]"]`);
        let total = 0;

        // Sumar los valores de los inputs
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0; // Usar 0 si el valor no es un número
            total += value;
        });

        // Actualizar el campo de Nota Final
        const finalGradeInput = document.getElementById(`notaFinal-${studentId}`);
        finalGradeInput.value = total; // Asignar la suma total al input de Nota Final
    }
</script>
