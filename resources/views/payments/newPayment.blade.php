<div class="w-full p-8 md:p-5">
    <form class="space-y-4" action="/payments/newForm/{{ $student->id }}" method="POST">
        @csrf

        @foreach ($users as $user)
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endforeach

        @php
            $paidMonths = $student->payments->pluck('paid_month')->toArray(); // Obtener los meses pagados por el estudiante
        @endphp

        {{-- CARGAR EL NOMBRE DEL ESTUDIANTE --}}
        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <label>Estudiante: </label>
            <input id="name{{ $student->id }}" name="name" class="w-full shadow-sm input"
                style="font-weight: bold; text-align: left;" readonly type="text"
                value="{{ $student->first_name }} {{ $student->second_name }} {{ $student->first_lastname }} {{ $student->second_lastname }}">
        </div>

        {{-- GRADO, SECCION & FECHA --}}
        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <div>
                <label>Grado y Sección: </label>
                <x-inputs.payment id="grade_id{{ $student->id }}" name="degree_id" readonly
                    style="text-align: center; font-weight: bold;"
                    value="{{ $studens->section_id ? strtoupper($studens->section_id) : '--- ----' }}" required />
            </div>
            <div>
                <label>Fecha: </label>
                <x-inputs.payment id="payment_date{{ $student->id }}" name="payment_date" readonly
                    style="text-align: center; font-weight: bold;" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}"
                    required />
            </div>
        </div>

        {{-- TIPO PAGO & METODO PAGO --}}
        <div class="flex items-center justify-end space-x-4 ">
            <div>
                <label>Tipo de Pago: </label>
                <x-inputs.select-option-payments name="type_payment" id="type_payment{{ $student->id }}"
                    titulo="" :options="[
                        'inscripcion' => 'Inscripcion',
                        'mensualidad' => 'Mensualidad',
                        'colaboracion' => 'Colaboracion'
                    ]" required class="border-2 border-gray-300"
                    onchange="togglePaymentOptions('{{ $student->id }}')" />
            </div>
            <div>
                <label>Metodo de Pago: </label>
                <x-inputs.select-option-payments name="mood_payment" id="mood_payment{{ $student->id }}"
                    titulo="" :options="[
                        'Efectivo' => 'Efectivo',
                        'Deposito' => 'Deposito',
                        'Transferencia' => 'Transferencia'
                    ]" required class="border-2 border-gray-300"
                    onchange="togglePaymentOptions('{{ $student->id }}')" />
            </div>
        </div>

        {{-- LISTAR COLABORACIONES --}}
        <div class="flex items-center justify-end mr-56 space-x-4" id="collaborations{{ $student->id }}">
            <div>
                <label>Colaboraciones: </label>
                <x-inputs.select-option-payments id="name_collaboration{{ $student->id }}" titulo=""
                    name="name_collaboration" :options="$collaborations->pluck('name', 'name')->toArray()" :selected="request('name_collaboration')" required
                    class="border-2 border-gray-300" onchange="togglePaymentOptions('{{ $student->id }}')" />
            </div>
        </div>

        {{-- METODO PAGO & TIPO BANCO --}}
        <div id="referenceFields{{ $student->id }}"
            class="flex items-center justify-center pb-2 space-x-4 border-b-2 border-gray-300">
            <div class="flex flex-col items-center">
                <x-inputs.payment id="document_number{{ $student->id }}" placeholder="No. Referencia"
                    name="document_number" class="border-2 border-gray-300" value="" type="number" />
            </div>
            <div class="flex flex-col items-center">
                <x-inputs.payment id="bank{{ $student->id }}" placeholder="Banco" name="bank"
                    class="border-2 border-gray-300" value="" />
            </div>
        </div>

        {{-- MESES DE PAGO --}}
        <div class="mb-4">
            Seleccione los meses de pago:
        </div>
        <div id="checkboxes{{ $student->id }}"
            class="flex items-center justify-center pb-4 space-x-4 border-b-2 border-gray-300">
            <div class="grid grid-cols-5 gap-6">
                @foreach ($months as $monthNumber => $monthName)
                    <div class="flex items-center justify-center">
                        <label class="flex items-center">
                            @if (in_array($monthNumber, $paidMonths))
                                <input type="checkbox" name="month[]" value="{{ $monthNumber }}" disabled checked
                                    class="mr-2">
                                <span>{{ $monthName }} (Pagado)</span>
                            @else
                                <input type="checkbox" name="month[]" value="{{ $monthNumber }}" class="mr-2">
                                <span>{{ $monthName }}</span>
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- OBSERVACIONES --}}
        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <label>Observaciones: </label>
            <input id="comment{{ $student->id }}" name="comment" class="w-full shadow-sm input"
                style="text-align: left;" type="text" value="">
        </div>

        {{-- TOTAL --}}
        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <label style="font-weight: bold; text-align: right;">TOTAL:</label>
            <input id="amount{{ $student->id }}" name="amount" class="w-full shadow-sm input"
                style="text-align: left;" type="number" value="" placeholder="Q. ">
        </div>

        <input type="hidden" name="student_id" value="{{ $student->id }}">

        {{-- BOTON PARA AGREGAR EL PAGO --}}
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
    </form>
    <x-alert-message />
</div>
<script>
    function initializePaymentForm(studentIds) {
        resetForm(studentIds); // Restablecer todos los campos al abrir el modal

        const typePayment = document.getElementById('type_payment' + studentIds);
        const moodPayment = document.getElementById('mood_payment' + studentIds);

        // Añadir los event listeners
        typePayment.addEventListener('change', () => togglePaymentOptions(studentIds));
        moodPayment.addEventListener('change', () => togglePaymentOptions(studentIds));

        // Configurar los checkboxes de meses
        document.querySelectorAll('input[name="month[]"]').forEach((checkbox) => {
            const label = checkbox.nextElementSibling;

            // Verifica si el checkbox es para un mes pagado
            if (label && label.textContent.includes("(Pagado)")) {
                checkbox.disabled = true; // Deshabilita los checkboxes de meses pagados
            } else {
                // Añadir event listener solo a los checkboxes no pagados
                checkbox.addEventListener('change', () => updateTotal(studentIds));
            }
        });
    }

    function togglePaymentOptions(studentId) {
        console.log(`Toggling payment options for student ID: ${studentId}`); // Debugging statement

        const typePayment = document.getElementById('type_payment' + studentId).value;
        const moodPayment = document.getElementById('mood_payment' + studentId).value;

        const checkboxes = document.getElementById('checkboxes' + studentId);
        const collaborations = document.getElementById('collaborations' + studentId);
        const collaborationSelect = document.getElementById('name_collaboration' + studentId);
        const referenceFields = document.getElementById('referenceFields' + studentId);

        // Mostrar/ocultar según tipo de pago
        if (typePayment === 'mensualidad') {
            checkboxes.classList.remove('hidden');
            collaborations.classList.add('hidden');
        } else if (typePayment === 'inscripcion') {
            checkboxes.classList.add('hidden');
            collaborations.classList.add('hidden');
        } else {
            checkboxes.classList.add('hidden');
            collaborations.classList.remove('hidden');
        }

        // Mostrar/ocultar según método de pago
        if (moodPayment === 'Deposito' || moodPayment === 'Transferencia') {
            referenceFields.classList.remove('hidden');
        } else {
            referenceFields.classList.add('hidden');
        }
    }

    function updateTotal(studentId) {
        let totalAmount = 0;

        // Calcular el total solo para los checkboxes no pagados y seleccionados
        document.querySelectorAll(`#checkboxes${studentId} input[name="month[]"]:checked`).forEach((checkbox) => {
            const label = checkbox.nextElementSibling;
            if (!label || !label.textContent.includes("(Pagado)")) {
                totalAmount += 75; // Asumiendo que cada mes no pagado tiene un costo de 75
            }
        });

        // Actualizar el campo total
        document.getElementById('amount' + studentId).value = totalAmount;
        console.log(`Total for student ID ${studentId}: ${totalAmount}`); // Debugging statement
    }

    function resetForm(studentIds) {
        // Reiniciar los valores de los selects y campos
        document.getElementById('type_payment' + studentIds).value = ""; // Valor por defecto
        document.getElementById('mood_payment' + studentIds).value = ""; // Valor por defecto
        document.getElementById('name_collaboration' + studentIds).value = ""; // Vaciar colaboraciones

        // Ocultar los checkboxes de meses
        document.getElementById('checkboxes' + studentIds).classList.add('hidden');
        document.querySelectorAll('input[name="month[]"]').forEach((checkbox) => {
            checkbox.checked = false; // Desmarcar meses
            // Deshabilitar solo los checkboxes de meses pagados
            const label = checkbox.nextElementSibling;
            checkbox.disabled = label && label.textContent.includes("(Pagado)");
        });

        // Limpiar los campos de referencia y banco
        document.getElementById('document_number' + studentIds).value = ""; // Vaciar referencia
        document.getElementById('bank' + studentIds).value = ""; // Vaciar banco

        // Reiniciar el total
        document.getElementById('amount' + studentIds).value = 0;

        // Concatenar y mostrar los IDs de estudiantes (puedes adaptar esto según lo que necesites)
        const studentIdsField = document.getElementById('student_ids'); // Asegúrate de que este ID exista
        studentIdsField.value = studentIds.join(', '); // Concatenar IDs con coma y espacio

        // Mostrar solo los campos predeterminados
        togglePaymentOptions(studentIds);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Agregar listeners para los checkboxes
        document.querySelectorAll('input[name="month[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const studentId = checkbox.closest('form').querySelector(
                    'input[name="student_id"]').value;
                updateTotal(studentId);
            });
        });

        // Inicializar al cargar
        const initialStudentIds = [...new Set(Array.from(document.querySelectorAll('input[name="student_id"]'))
            .map(input => input.value))];
        initialStudentIds.forEach(studentId => updateTotal(studentId));
    });
</script>
