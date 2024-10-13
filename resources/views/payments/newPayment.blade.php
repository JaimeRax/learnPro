<div class="p-8 md:p-5 w-full">
    <form class="space-y-4" action="/payments/newForm/{{ $student->id }}" method="POST">
        @csrf

        @foreach ($users as $user)
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endforeach

        {{-- CARGAR EL NOMBRE DEL ESTUDIANTE --}}
        <input id="name{{ $student->id }}" name="name" class="w-full shadow-sm input"
            style="font-weight: bold; text-align: center;" readonly type="text"
            value="{{ $student->first_name }} {{ $student->second_name }} {{ $student->first_lastname }} {{ $student->second_lastname }}">

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- TIPO DE PAGO Y FECHA --}}
        <div class="flex items-center justify-end space-x-4">
            <div class="flex-1 text-center">
                <label style="font-weight: bold;">Tipo de Pago:</label>
            </div>
            <div>
                <x-inputs.select-option name="type_payment" id="type_payment" titulo="" titulo=""
                    :options="[
                        'inscripcion' => 'Inscripcion',
                        'mensualidad' => 'Mensualidad',
                        'colaboracion' => 'Colaboracion'
                    ]" required onchange="toggleMesesPago(this, '{{ $student->id }}')" />
            </div>

            {{-- TODO: agregar fecha --}}
            {{-- <div class="p-4 ml-16 text-base rounded"> --}}
            {{--     Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }} --}}
            {{--     <input type="hidden" name="payment_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" /> --}}
            {{-- </div> --}}
        </div>

        <div class="flex items-center justify-end space-x-4">
            <div class="flex-1 text-center">
                <label style="font-weight: bold;">Metodo de Pago:</label>
            </div>
            <div>
                <x-inputs.select-option name="mood_payment" id="mood_payment" titulo="" :options="[
                    'Efectivo' => 'Efectivo',
                    'Deposito' => 'Deposito',
                    'Transferencia' => 'Transferencia'
                ]" required
                    onchange="toggleMesesPago(this, '{{ $student->id }}')" />
            </div>
        </div>

        {{-- Metodo pago y tipo banco --}}
        <div class="flex items-center justify-center space-x-4">
            <div class="flex flex-col items-center">
                <x-inputs.general id="document_number" placeholder="No. Referencia" name="document_number"
                    value="" />
            </div>
            <div class="flex flex-col items-center">
                <x-inputs.general id="bank" placeholder="Banco" name="bank" value="" />
            </div>
        </div>

        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- MESES DE PAGO --}}
        <div id="meses-pago_{{ $student->id }}">
            <div class="tw-grid tw-grid-cols-5 tw-gap-6">
                <div class="mb-8 text-lg mt-7">
                    Seleccione los meses de pago:
                </div>
                <!-- Primera fila -->
                <label class="ml-5 cursor-pointer tw-label">
                    <span class="tw-label-text">ene</span>
                    <input type="checkbox" name="month" id="enero" value="enero" id="mes_1_{{ $student->id }}"
                        class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">feb</span>
                    <input type="checkbox" name="month" id="febrero" value="febrero" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">mar</span>
                    <input type="checkbox" name="month" id="marzo" value="marzo" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">abr</span>
                    <input type="checkbox" name="month" id="abril" value="abril" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">may</span>
                    <input type="checkbox" name="month" id="mayo" value="mayo" class="tw-checkbox">
                </label>
            </div>

            <div class="mt-4 tw-grid tw-grid-cols-5 tw-gap-6">
                <!-- Segunda fila -->
                <label class="ml-6 cursor-pointer tw-label">
                    <span class="tw-label-text">jun</span>
                    <input type="checkbox" name="month" id="junio" value="junio" class="tw-checkbox">
                </label>
                <label class="cursor-pointer ml-11 tw-label">
                    <span class="tw-label-text">jul</span>
                    <input type="checkbox" name="month" id="julio" value="julio" class="tw-checkbox">
                </label>
                <label class="cursor-pointer ml-11 tw-label">
                    <span class="tw-label-text">ago</span>
                    <input type="checkbox" name="month" id="agosto" value="agosto" class="tw-checkbox">
                </label>
                <label class="ml-10 cursor-pointer tw-label">
                    <span class="tw-label-text">sep</span>
                    <input type="checkbox" name="month" id="septiembre" value="septiembre" class="tw-checkbox">
                </label>
                <label class="ml-12 cursor-pointer tw-label">
                    <span class="tw-label-text">oct</span>
                    <input type="checkbox" name="month" id="octubre" value="octubre" class="tw-checkbox">
                </label>
            </div>
        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1" id="linea2_{{ $student->id }}">

        {{-- TOTAL --}}
        <div class="flex items-center space-x-4">
            <x-inputs.general id="amount" titulo="Total" name="amount" value="0" />
        </div>

        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        <div class="flex items-center space-x-4">
            <x-inputs.general id="comment" titulo="Observaciones" name="comment" />
        </div>
        <hr class="mt-4 border-gray-300 border-solid rounded-full mb-7 border-1">

        {{-- BOTON PARA AGREGAR EL PAGO --}}
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>

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
        const totalInput = document.getElementById('amount');
        const tipoPago = selectElement.value; // Obtener el valor seleccionado (1 para Inscripción, 2 para Mensualidad)

        if (tipoPago == 'inscripcion') { // Inscripción
            totalInput.value = 75;
            mesesPagoDiv.style.display = 'none'; // Ocultar los meses de pago
            section_id.style.display = 'none';
            grade_id.style.display = 'none';
            linea1.style.display = 'none';
            linea2.style.display = 'none';

            // Marcar el checkbox del mes 1
            const mes1Checkbox = document.getElementById('enero');
            if (mes1Checkbox) {
                mes1Checkbox.checked = true; // Marcar el mes 1
            }
        } else if (tipoPago == 'mensualidad') { // Mensualidad
            totalInput.value = 0; // Inicializamos el total en 0
            mesesPagoDiv.style.display = 'block'; // Mostrar los meses de pago
            section_id.style.display = 'block';
            grade_id.style.display = 'block';
            linea1.style.display = 'block';
            linea2.style.display = 'block';

            // Desmarcar el checkbox del mes 1 si es necesario
            const mes1Checkbox = document.getElementById('mes_1_' + studentId);
            if (mes1Checkbox) {
                mes1Checkbox.checked = false; // Desmarcar el mes 1 si selecciona mensualidad
            }
        } else { // Otras opciones como Colaboración
            mesesPagoDiv.style.display = 'none';
            section_id.style.display = 'none';
            grade_id.style.display = 'none';
            linea1.style.display = 'none';
            linea2.style.display = 'none';

            // Desmarcar el checkbox del mes 1 si es necesario
            const mes1Checkbox = document.getElementById('mes_1_' + studentId);
            if (mes1Checkbox) {
                mes1Checkbox.checked = false; // Desmarcar el mes 1
            }
        }
    }

    // Esta función se ejecuta cuando se selecciona un mes
    function updateTotal(studentId) {
        const selectedMonths = document.querySelectorAll(`#meses-pago_${studentId} input[type="checkbox"]:checked`);
        const totalInput = document.getElementById(`amount`);

        // Calcular el total basado en el número de meses seleccionados
        totalInput.value = selectedMonths.length * 75;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Añadir un event listener a todos los inputs de meses para manejar la selección
        const mesesInputs = document.querySelectorAll(`input[type="checkbox"]`);
        mesesInputs.forEach(input => {
            input.addEventListener('change', function() {
                const studentId = this.closest('div[id^="meses-pago_"]').id.split('_')[1];
                updateTotal(studentId);
            });
        });
    });
</script>
