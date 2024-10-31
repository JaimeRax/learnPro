@extends('layouts.base')

@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">
        {{-- BOTON PARA VOLVER --}}

        <div class="flex justify-end col-md-2">
            <x-button-link href="/activity" class="mt-2 text-white bg-orange-400">

                <x-iconos.volver /> Volver

            </x-button-link>
        </div>

        <div class="p-4 md:p-5">
            <form id="activityForm" class="space-y-4" action="/activity/new" method="POST">
                @csrf
                <x-inputs.general id="year" name="year" style="text-align: center; font-weight: bold;"
                    value="{{ \Carbon\Carbon::now()->format('Y') }}" required />

                <div class="flex items-center justify-center pb-1 space-x-4 border-b-2 border-gray-300">
                    <div>
                        <x-inputs.general type="date" name="date_entity" id="date_entity" titulo="Fecha de entrega"
                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                            required />
                    </div>
                    <div>
                        <x-inputs.select-option name="bimester" id="bimester" titulo="Bimestre" :options="[
                            '1' => 'I Bimestre',
                            '2' => 'II Bimestre',
                            '3' => 'III Bimestre',
                            '4' => 'IV Bimestre'
                        ]" required
                            class="border-2 border-gray-300" />
                    </div>
                    <div>
                        <x-inputs.general type="text" name="name" id="name" titulo="Nombre de la actividad"
                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                            required />
                    </div>
                    <div>
                        <x-inputs.general type="number" name="plucking" id="plucking" titulo="Punteo" min="0"
                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                            required />
                    </div>
                </div>

                <div class="flex items-center justify-center pb-1 space-x-4 border-b-2 border-gray-300">
                    <div>
                        <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" required />
                    </div>
                    <div>
                        <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                            required />
                    </div>
                    <div>
                        <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()" required />
                    </div>
                </div>

                <button type="button" id="addRowBtn"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
            </form>

            <table id="activityTable" class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Fecha de entrega</th>
                        <th class="py-2">Bimestre</th>
                        <th class="py-2">Nombre de la actividad</th>
                        <th class="py-2">Punteo</th>
                        <th class="py-2">Grado</th>
                        <th class="py-2">Sección</th>
                        <th class="py-2">Curso</th>
                        <th class="py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <button id="saveAllBtn"
                class="mt-4 w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar
                Todo</button>

            {{-- mensaje de exito o error al crear un curso --}}
            <x-alert-message />
        </div>
    </div>
@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let year = $('#year').val();
        $('#addRowBtn').on('click', function() {

            let dateEntity = $('#date_entity').val();
            let bimester = $('#bimester').find(':selected').val();
            let name = $('#name').val();
            let plucking = $('#plucking').val();
            let degreeText = $('#degree_id').find(':selected').text();
            let degreeId = $('#degree_id').val(); // Obtiene el ID numérico
            let sectionText = $('#section_id').find(':selected').text();
            let sectionId = $('#section_id').val(); // Obtiene el ID numérico
            let courseText = $('#course_id').find(':selected').text();
            let courseId = $('#course_id').val(); // Obtiene el ID numérico

            let row = `
        <tr data-degree-id="${degreeId}" data-section-id="${sectionId}" data-course-id="${courseId}">
            <td class="py-2">${dateEntity}</td>
            <td class="py-2">${bimester}</td>
            <td class="py-2">${name}</td>
            <td class="py-2">${plucking}</td>
            <td class="py-2">${degreeText}</td>
            <td class="py-2">${sectionText}</td>
            <td class="py-2">${courseText}</td>
            <td class="py-2">
                <button type="button" class="text-red-500 removeRowBtn hover:underline">Eliminar</button>
            </td>
        </tr>
    `;
            $('#activityTable tbody').append(row);
        });

        $('#saveAllBtn').on('click', function() {
            let rows = [];
            $('#activityTable tbody tr').each(function() {
                let row = {
                    year: year,
                    date_entity: $(this).find('td:eq(0)').text(),
                    bimester: $(this).find('td:eq(1)').text(),
                    name: $(this).find('td:eq(2)').text(),
                    plucking: $(this).find('td:eq(3)').text(),
                    degree: $(this).data('degree-id'), // Usa el ID en lugar del texto
                    section: $(this).data('section-id'), // Usa el ID en lugar del texto
                    course: $(this).data('course-id') // Usa el ID en lugar del texto
                };
                rows.push(row);
            });
            console.log(rows);
            $.ajax({
                url: '/activity/new',
                method: 'POST',
                data: {
                    activities: rows,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    swal("Éxito", "Todas las actividades fueron guardadas", "success");
                    $('#activityTable tbody').empty();
                },
                error: function() {
                    swal("Error", "Hubo un problema al guardar las actividades", "error");
                }
            });
        });

    });
</script>
