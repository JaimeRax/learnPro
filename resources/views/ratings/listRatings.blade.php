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

        <div class="mt-6">
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

                        </x-tablas.tr>
                    @endforeach
                </x-slot>

            </x-tablas.table>
            <div class="flex justify-end mt-4">
                <!-- Cambiamos el botón para que edite todas las calificaciones -->
                <x-button type="button" class="text-white bg-blue-600" onclick="editAllRatings()">
                    Guardar Calificaciones
                </x-button>
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
        const inputs = document.querySelectorAll(`input[name^="ratings[${studentId}]"]`);
        let total = 0;

        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });

        const finalGradeInput = document.getElementById(`notaFinal-${studentId}`);
        finalGradeInput.value = total;
    }

    function editAllRatings() {
        const formData = new FormData();
        const students = @json($students);

        students.forEach(student => {
            const inputs = document.querySelectorAll(`input[name^="ratings[${student.id}]"]`);
            inputs.forEach(input => {
                const activityId = input.name.match(/ratings\[(\d+)\]\[(\d+)\]/)[2];
                formData.append(`ratings[${student.id}][${activityId}][score_obtained]`, input.value);
            });
        });

        fetch('{{ route('ratings.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert('Ocurrió un error al actualizar las calificaciones.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al enviar la solicitud.');
        });
    }
</script>
