<div class="p-4 md:p-5">
    <form class="space-y-4" action="courses/new" method="POST">
        @csrf

        {{-- CARGAR EL NOMBRE DEL ESTUDIANTE --}}
        <input id="name{{ $student->id }}" name="name" class="w-full shadow-sm input" readonly
            type="text"
            value="{{ $student->first_name }} {{ $student->second_name }} {{ $student->first_lastname }} {{ $student->second_lastname }}">

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- TIPO DE PAGO Y FECHA --}}
        <div class="flex items-center space-x-4">
            <x-inputs.select-option id="mod_{{ $student->id }}" titulo="" :options="[
                1 => 'Inscripcion',
                2 => 'Mensualidad',
                3 => 'Colaboracion'
            ]" required
                onchange="toggleMesesPago(this, '{{ $student->id }}')" />


            <div class="p-4 ml-16 text-base rounded">
                Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- GRADO Y SECCION --}}
        <div class="flex items-center space-x-4">
            <div id="grade_id_{{ $student->id }}">
                <label for="grade_id_{{ $student->id }}" class="block text-sm font-medium text-gray-700">Grado:</label>
                <x-inputs.select-option id="grade_id_{{ $student->id }}" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()"
                    required />
            </div>

            <div id="section_id_{{ $student->id }}">
                <label for="section_id_{{ $student->id }}"
                    class="block text-sm font-medium text-gray-700">Sección:</label>
                <x-inputs.select-option id="section_id_{{ $student->id }}" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                    required />
            </div>
        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1" id="linea1_{{ $student->id }}">

        {{-- MESES DE PAGO --}}
        <div id="meses-pago_{{ $student->id }}">
            <div class="tw-grid tw-grid-cols-5 tw-gap-6">
                <div class="mb-8 text-lg mt-7">
                    Seleccione los meses de pago:
                </div>
                <!-- Primera fila -->
                <label class="ml-5 cursor-pointer tw-label">
                    <span class="tw-label-text">ene</span>
                    <input type="checkbox" name="individual[]" id="enero" value="1" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">feb</span>
                    <input type="checkbox" name="individual[]" id="febrero" value="2" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">mar</span>
                    <input type="checkbox" name="individual[]" id="marzo" value="3" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">abr</span>
                    <input type="checkbox" name="individual[]" id="abril" value="4" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">may</span>
                    <input type="checkbox" name="individual[]" id="mayo" value="5" class="tw-checkbox">
                </label>
            </div>

            <div class="mt-4 tw-grid tw-grid-cols-5 tw-gap-6">
                <!-- Segunda fila -->
                <label class="ml-6 cursor-pointer tw-label">
                    <span class="tw-label-text">jun</span>
                    <input type="checkbox" name="individual[]" id="junio" value="6" class="tw-checkbox">
                </label>
                <label class="cursor-pointer ml-11 tw-label">
                    <span class="tw-label-text">jul</span>
                    <input type="checkbox" name="individual[]" id="julio" value="7" class="tw-checkbox">
                </label>
                <label class="cursor-pointer ml-11 tw-label">
                    <span class="tw-label-text">ago</span>
                    <input type="checkbox" name="individual[]" id="agosto" value="8" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">sep</span>
                    <input type="checkbox" name="individual[]" id="septiembre" value="9" class="tw-checkbox">
                </label>
                <label class="ml-12 cursor-pointer tw-label">
                    <span class="tw-label-text">oct</span>
                    <input type="checkbox" name="individual[]" id="octubre" value="10" class="tw-checkbox">
                </label>
            </div>

        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1" id="linea2_{{ $student->id }}">

        {{-- TOTAL --}}
        <div class="flex items-center space-x-4">
            <x-inputs.general id="total_{{ $student->id }}" titulo="Total" name="total" readonly value="0" />
        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- BOTON PARA AGREGAR EL PAGO --}}
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
        <a href="{{ url('payments/pdf_generator') }}" class="btn btn-secondary">PDF</a>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

    </form>

    <x-alert-message />
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectMod = document.getElementById('mod_{{ $student->id }}');

        const studentIdInput = document.getElementById('student_id_{{ $student->id }}');

        selectMod.addEventListener('change', function() {
            toggleMesesPago(this, '{{ $student->id }}');
        });
    });

    function toggleMesesPago(selectElement, studentId) {

        const mesesPagoDiv = document.getElementById('meses-pago_' + studentId);
        const section_id = document.getElementById('section_id_' + studentId);
        const grade_id = document.getElementById('grade_id_' + studentId);
        const linea1 = document.getElementById('linea1_' + studentId);
        const linea2 = document.getElementById('linea2_' + studentId);

        if (selectElement.value == '2') {
            mesesPagoDiv.style.display = 'block';
            section_id.style.display = 'block';
            grade_id.style.display = 'block';
            linea1.style.display = 'block';
            linea2.style.display = 'block';
        } else {
            mesesPagoDiv.style.display = 'none';
            section_id.style.display = 'none';
            grade_id.style.display = 'none';
            linea1.style.display = 'none';
            linea2.style.display = 'none';
        }
    }

    function toggleMesesPago(selectElement, studentId) {
        const mesesPagoDiv = document.getElementById(`meses-pago_${studentId}`);
        const totalInput = document.getElementById(`total_${studentId}`);
        const tipoPago = selectElement.value; // Obtener el valor seleccionado (1 para Inscripción, 2 para Mensualidad)

        if (tipoPago == 1) { // Inscripción
            totalInput.value = 75;
            mesesPagoDiv.style.display = 'none'; // Ocultar los meses de pago
        } else if (tipoPago == 2) { // Mensualidad
            totalInput.value = 0; // Inicializamos el total en 0
            mesesPagoDiv.style.display = 'block'; // Mostrar los meses de pago
        }
    }

    // Esta función se ejecuta cuando se selecciona un mes
    function updateTotal(studentId) {
        const selectedMonths = document.querySelectorAll(`#meses-pago_${studentId} input[type="checkbox"]:checked`);
        const totalInput = document.getElementById(`total_${studentId}`);

        // Calcular el total basado en el número de meses seleccionados
        totalInput.value = selectedMonths.length * 75;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Añadir un event listener a todos los inputs de meses para manejar la selección
        const mesesInputs = document.querySelectorAll(`input[type="checkbox"]`);
        mesesInputs.forEach(input => {
            input.addEventListener('change', function () {
                const studentId = this.closest('div[id^="meses-pago_"]').id.split('_')[1];
                updateTotal(studentId);
            });
        });
    });

</script>
