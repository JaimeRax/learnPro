@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="HISTORIAL DE PAGOS" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        @php
            function getMonthName($monthNumber)
            {
                $months = [
                    1 => 'ENERO',
                    2 => 'FEBRERO',
                    3 => 'MARZO',
                    4 => 'ABRIL',
                    5 => 'MAYO',
                    6 => 'JUNIO',
                    7 => 'JULIO',
                    8 => 'AGOSTO',
                    9 => 'SEPTIEMBRE',
                    10 => 'OCTUBRE'
                ];

                return $months[$monthNumber] ?? '---'; // Para números fuera del rango
            }
        @endphp
        <div class="mt-4">

            {{-- Botón de Volver alineado a la derecha --}}
            <div class="text-right mb-4">
                <x-button-link href="/payments" class="mt-2 text-white bg-orange-400">
                    <x-iconos.volver /> VOLVER
                </x-button-link>
            </div>

            <div class="bg-blue-100 rounded-lg p-4 w-full text-center mb-8">
                <span class="text-gray-600 text-lg">ESTUDIANTE:</span>
                <strong class="text-black-800 text-xl font-bold">
                    {{ strtoupper("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}") }}
                </strong>
            </div>

            @if ($payments->isEmpty())
                <div class="bg-red-100 rounded-lg p-4 w-full text-center mb-8">
                    <strong class="text-black-800 text-xl font-bold">
                        <p>NO HAY PAGOS REGISTRADOS PARA ESTE ESTUDIANTE.</p>
                    </strong>
                </div>
            @else
                <x-tablas.table wire:loading.remove id="table" data-name="listPaymentsHistory">
                    <x-slot name="thead">
                        <x-tablas.tr>
                            <x-tablas.th>FECHA</x-tablas.th>
                            <x-tablas.th>MONTO</x-tablas.th>
                            <x-tablas.th>DESCRIPCIÓN</x-tablas.th>
                            <x-tablas.th>MÉTODO DE PAGO</x-tablas.th>
                            <x-tablas.th>MES PAGADO</x-tablas.th>
                            <x-tablas.th>ACCIONES</x-tablas.th>
                        </x-tablas.tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($payments as $payment)
                            <x-tablas.tr>
                                <x-tablas.td>{{ $payment->payment_date }}</x-tablas.td>
                                <x-tablas.td>{{ $payment->amount }}</x-tablas.td>
                                <x-tablas.td>{{ $payment->type_payment }}</x-tablas.td>
                                <x-tablas.td>{{ $payment->mood_payment }}</x-tablas.td>
                                <x-tablas.td>{{ getMonthName($payment->paid_month) }}</x-tablas.td>
                                <x-tablas.td>
                                    <x-modal id="delete{{ $payment->id }}" title="Eliminar"
                                        bstyle="border-none bg-yellow-400 text-white hover:bg-yellow-600">
                                        <x-slot name="button">
                                            <div class="relative group">
                                                <x-iconos.basurero />
                                                <div
                                                    class="absolute bottom-full left-1/2 z-50 mb-2 hidden w-max rounded-md bg-white px-3 py-2 text-sm text-black shadow-lg group-hover:block transform -translate-x-1/2 font-normal">
                                                    Eliminar Estudiante
                                                </div>
                                            </div>
                                        </x-slot>
                                        <x-slot name="body">
                                            <p class="text-lg text-center mt-5 mb-8">
                                                <span class="text-yellow-500 text-lg mr-2">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </span>
                                                <strong>Advertencia:</strong>
                                            </p>
                                            <p>Esta acción es irreversible. Una vez que elimine el pago, no podrá
                                                recuperarlo.</p>
                                            <p class="mt-5 mb-4 text-sm text-center">¿Está seguro de eliminar el pago ?</p>
                                            <form action="{{ url('/payments/delete/' . $payment->id) }}" method="POST"
                                                id="delete-form{{ $payment->id }}">
                                                @csrf
                                                <div class="flex justify-center mb-4">
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $payment->student->first_name . $payment->student->first_lastname }}', '{{ $payment->type_payment }}', '{{ $payment->id }}')"
                                                        class="px-5 py-2 mt-5 text-sm font-bold bg-blue-700 rounded text-gray-50">
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </form>
                                        </x-slot>
                                    </x-modal>

                                    <button class="btn bg-red-400 hover:bg-red-600 text-white"
                                        onclick="window.open('{{ session('pdf_url') }}', '_blank');">
                                        <div class="relative group">
                                            <x-iconos.pdf />
                                            <div
                                                class="absolute bottom-full left-1/2 z-50 mb-2 hidden w-max rounded-md bg-white px-3 py-2 text-sm text-black shadow-lg group-hover:block transform -translate-x-1/2 font-normal">
                                                descargar comprobante
                                            </div>
                                        </div>
                                    </button>
                                </x-tablas.td>
                            </x-tablas.tr>
                        @endforeach
                    </x-slot>
                </x-tablas.table>
                <div>
                    {{ $payments->appends(['search' => request()->query('search')])->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(nameStudent, paymentDescription, paymentId) {
        const confirmationText = `${nameStudent}/${paymentDescription}`;

        Swal.fire({
            title: "Confirmación de Eliminación",
            html: "Recuerda que esta acción es irreversible y no podrás recuperar la información eliminada.<br><br>" +
                "Para confirmar, escribe la descripción del pago: <strong>" + nameStudent + "/" +
                paymentDescription + "</strong>",
            input: 'text',
            inputPlaceholder: 'Descripción del pago',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            icon: 'warning',
            preConfirm: (inputValue) => {
                if (inputValue !== confirmationText) {
                    Swal.showValidationMessage(
                        'La descripción no coincide. Por favor, inténtalo de nuevo.');
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario escribió correctamente la descripción
                document.querySelector(`#delete-form${paymentId}`).submit();
            }
        });
    }
</script>
