<div class="p-8 md:p-5 w-full">
    <form class="space-y-4" action="/payments/newForm/{{ $student->id }}" method="POST">
        @csrf

        @foreach ($users as $user)
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endforeach

        @php
            $paidMonths = $student->payments->pluck('month')->toArray(); // Obtener los meses pagados por el estudiante
        @endphp


        {{-- CARGAR EL NOMBRE DEL ESTUDIANTE --}}
        <div class="flex items-center justify-end space-x-4 border-b-2 border-gray-300 pb-1">
            <label>Estudiante: </label>
            <input id="name{{ $student->id }}" name="name" class="w-full shadow-sm input"
                style="font-weight: bold; text-align: left;" readonly type="text"
                value="{{ $student->first_name }} {{ $student->second_name }} {{ $student->first_lastname }} {{ $student->second_lastname }}">
        </div>


        {{-- GRADO, SECCION & FECHA --}}
        <div class="flex items-center justify-end space-x-4 border-b-2 border-gray-300 pb-1">
            <div>
                <label>Grado y Sección: </label>
                <x-inputs.general id="grade_id" name="degree_id" style="text-align: center; font-weight: bold;"
                    value="primero A quemado" required />
            </div>
            <div>
                <label>Fecha: </label>
                <x-inputs.general id="payment_date" name="date" style="text-align: center; font-weight: bold;"
                    value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" required />
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


        {{-- METODO PAGO & TIPO BANCO --}}
        <div id="referenceFields" class="flex items-center justify-center space-x-4 border-b-2 border-gray-300 pb-2">
            <div class="flex flex-col items-center">
                <x-inputs.general id="document_number" placeholder="No. Referencia" name="document_number"
                    class="border-2 border-gray-300" value="" />
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
        <div id="checkboxes" class="flex items-center justify-center space-x-4 border-b-2 border-gray-300 pb-4">
            <div class="grid grid-cols-5 gap-6">
                @foreach ($months as $monthNumber => $monthName)
                    <div class="flex items-center justify-center">
                        <label class="flex items-center">
                            @if (in_array($monthNumber, $paidMonths))
                                <input type="checkbox" name="months[]" value="{{ $monthNumber }}" disabled checked
                                    class="mr-2">
                                <span>{{ $monthName }} (Pagado)</span>
                            @else
                                <input type="checkbox" name="months[]" value="{{ $monthNumber }}" class="mr-2">
                                <span>{{ $monthName }}</span>
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- OBSERVACIONES --}}
        <div class="flex items-center justify-end space-x-4 border-b-2 border-gray-300 pb-1">
            <label>Observaciones: </label>
            <input id="comment" name="comment" class="w-full shadow-sm input" style="text-align: left;" type="text"
                value="">
        </div>


        {{-- TOTAL --}}
        <div class="flex items-center justify-end space-x-4 border-b-2 border-gray-300 pb-1">
            <label style="font-weight: bold; text-align: right;">TOTAL:</label>
            <input id="amount" name="amount" class="w-full shadow-sm input" style="text-align: left;" type="number"
                value="" placeholder="Q. ">
        </div>

        <input type="hidden" name="student_id" value="{{ $student->id }}">


        {{-- BOTON PARA AGREGAR EL PAGO --}}
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
    </form>
</div>


<script>
    function togglePaymentOptions() {
        const typePayment = document.getElementById('type_payment').value;
        const moodPayment = document.getElementById('mood_payment').value;

        // Mostrar/ocultar los checkboxes
        const checkboxes = document.getElementById('checkboxes');
        if (typePayment === 'mensualidad') {
            checkboxes.classList.remove('hidden');
        } else {
            checkboxes.classList.add('hidden');
        }

        // Mostrar/ocultar No. Referencia y Banco
        const referenceFields = document.getElementById('referenceFields');
        if (moodPayment === 'Efectivo') {
            referenceFields.classList.add('hidden');
        } else {
            referenceFields.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', togglePaymentOptions);
</script>
