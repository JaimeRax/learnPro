<div class="w-full p-8 md:p-5">
    <form class="space-y-4" action="/payments/newForm/{{ $student->id }}" method="POST">
        @csrf

        @foreach ($users as $user)
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endforeach

        @php
            $paidMonths = $student->payments->pluck('month')->toArray(); // Obtener los meses pagados por el estudiante
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
                <x-inputs.general id="grade_id" name="degree_id" readonly
                    style="text-align: center; font-weight: bold;"
                    value="{{ $studens->section_id ? strtoupper($studens->section_id) : '--- ----' }}" required />
            </div>
            <div>
                <label>Fecha: </label>
                <x-inputs.general id="payment_date" name="date" readonly
                    style="text-align: center; font-weight: bold;" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}"
                    required />
            </div>
        </div>

        {{-- TIPO PAGO & METODO PAGO --}}
        <div class="flex items-center justify-end space-x-4 ">
            <div>
                <label>Tipo de Pago: </label>
                <x-inputs.select-option name="type_payment" id="type_payment" titulo="" :options="[
                    'inscripcion' => 'Inscripcion',
                    'mensualidad' => 'Mensualidad',
                    'colaboracion' => 'Colaboracion'
                ]" required
                    class="border-2 border-gray-300" onchange="togglePaymentOptions()" />
            </div>
            <div>
                <label>Metodo de Pago: </label>
                <x-inputs.select-option name="mood_payment" id="mood_payment" titulo="" :options="[
                    'Efectivo' => 'Efectivo',
                    'Deposito' => 'Deposito',
                    'Transferencia' => 'Transferencia'
                ]" required
                    class="border-2 border-gray-300" onchange="togglePaymentOptions()" />
            </div>
        </div>

        {{-- LISTAR COLABORACIONES --}}
        <div class="flex items-center justify-end mr-56 space-x-4" id="collaborations">
            <div>
                <label>Colaboraciones: </label>
                <x-inputs.select-option id="name_collaboration" titulo="" name="name_collaboration"
                    :options="$collaborations->pluck('name', 'name')->toArray()" :selected="request('name_collaboration')" required class="border-2 border-gray-300"
                    onchange="togglePaymentOptions()" />
            </div>
        </div>

        {{-- METODO PAGO & TIPO BANCO --}}
        <div id="referenceFields" class="flex items-center justify-center pb-2 space-x-4 border-b-2 border-gray-300">
            <div class="flex flex-col items-center">
                <x-inputs.general id="document_number" placeholder="No. Referencia" name="document_number"
                    class="border-2 border-gray-300" value="" type="number" />
            </div>
            <div class="flex flex-col items-center">
                <x-inputs.general id="bank" placeholder="Banco" name="bank" class="border-2 border-gray-300"
                    value="" />
            </div>
        </div>

        {{-- MESES DE PAGO --}}
        <div class="mb-4">
            Seleccione los meses de pago:
        </div>
        <div id="checkboxes" class="flex items-center justify-center pb-4 space-x-4 border-b-2 border-gray-300">
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
            <input id="comment" name="comment" class="w-full shadow-sm input" style="text-align: left;" type="text"
                value="">
        </div>

        {{-- TOTAL --}}
        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <label style="font-weight: bold; text-align: right;">TOTAL:</label>
            <input id="amount" name="amount" class="w-full shadow-sm input" style="text-align: left;" type="number"
                value="" placeholder="Q. ">
        </div>

        <input type="hidden" name="student_id" value="{{ $student->id }}">

        {{-- BOTON PARA AGREGAR EL PAGO --}}
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
    </form>
    <x-alert-message />
</div>

<script>
    // Inicializa el formulario y establece el estado por defecto
    function initializePaymentForm() {
        resetForm(); // Restablecer todos los campos al abrir el modal

        const typePayment = document.getElementById('type_payment');
        const moodPayment = document.getElementById('mood_payment');

        // Añadir los event listeners
        typePayment.addEventListener('change', togglePaymentOptions);
        moodPayment.addEventListener('change', togglePaymentOptions);
    }

    function togglePaymentOptions() {
        const typePayment = document.getElementById('type_payment').value;
        const moodPayment = document.getElementById('mood_payment').value;

        // Mostrar/ocultar los checkboxes de meses
        const checkboxes = document.getElementById('checkboxes');
        const collaborations = document.getElementById('collaborations');
        const collaborationSelect = document.getElementById('name_collaboration');
        const referenceFields = document.getElementById('referenceFields');

        // Lógica de tipo de pago
        if (typePayment === 'mensualidad') {
            checkboxes.classList.remove('hidden');
            collaborationSelect.value = ""; // Vaciar colaboraciones
            collaborations.classList.add('hidden');
        } else if (typePayment === 'inscripcion') {
            checkboxes.classList.add('hidden');
            collaborationSelect.value = ""; // Vaciar colaboraciones
            collaborations.classList.add('hidden');
            document.querySelectorAll('input[name="month[]"]').forEach((checkbox) => {
                checkbox.checked = false; // Desmarcar meses
            });
        } else if (typePayment === 'colaboracion') {
            checkboxes.classList.add('hidden');
            collaborations.classList.remove('hidden');
            document.querySelectorAll('input[name="month[]"]').forEach((checkbox) => {
                checkbox.checked = false; // Desmarcar meses
            });
        }

        // Lógica de método de pago
        if (moodPayment === 'Efectivo') {
            referenceFields.classList.add('hidden');
            document.getElementById('document_number').value = ""; // Vaciar referencia
            document.getElementById('bank').value = ""; // Vaciar banco
        } else {
            referenceFields.classList.remove('hidden');
        }
    }

    function resetForm() {
        // Reiniciar los valores de los selects y campos
        document.getElementById('type_payment').value = ""; // Valor por defecto
        document.getElementById('mood_payment').value = ""; // Valor por defecto
        document.getElementById('name_collaboration').value = ""; // Vaciar colaboraciones

        // Ocultar los checkboxes de meses
        document.getElementById('checkboxes').classList.add('hidden');
        document.querySelectorAll('input[name="month[]"]').forEach((checkbox) => {
            checkbox.checked = false; // Desmarcar meses
        });

        // Limpiar los campos de referencia y banco
        document.getElementById('document_number').value = ""; // Vaciar referencia
        document.getElementById('bank').value = ""; // Vaciar banco

        // Mostrar solo los campos predeterminados
        togglePaymentOptions();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const modals = document.querySelectorAll('.modal'); // Ajusta esto según tu implementación
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal',
                initializePaymentForm); // Cuando se muestre el modal
            modal.addEventListener('hidden.bs.modal',
                resetForm); // Restablecer el formulario al cerrar el modal
        });
    });
</script>
