@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
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
        {{-- Lista de Pagos --}}
        <div class="mt-4">
            <h2 class="text-xl font-semibold"><strong>Pagos</strong></h2>
            {{-- Botón de Volver alineado a la derecha --}}
            <div class="text-right mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
            <br>
            @if ($payments->isEmpty())
                <p>No hay pagos registrados para este estudiante.</p>
            @else
                <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
                    <x-slot name="thead">
                        <x-tablas.tr>
                            <x-tablas.th>Fecha</x-tablas.th>
                            <x-tablas.th>Monto</x-tablas.th>
                            <x-tablas.th>Descripción</x-tablas.th>
                            <x-tablas.th>Metodo de Pago</x-tablas.th>
                            <x-tablas.th>Mes Pagado</x-tablas.th>
                            <x-tablas.th>Acciones</x-tablas.th>

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
                                        bstyle="border-none bg-red-600 text-white hover:bg-red-800">
                                        <x-slot name="button">
                                            <x-iconos.basurero />
                                        </x-slot>

                                        <x-slot name="body">
                                            <br>
                                            <strong>Advertencia:</strong> Esta acción es irreversible. Una vez que elimine

                                            el pago, no podrá recuperarlo.

                                            <p class="mt-5 mb-4 text-sm text-center">¿Está seguro de eliminar el pago ?</p>
                                            <form action="{{ url('/payments/delete/' . $payment->id) }}" method="POST"
                                                id="delete-form{{ $payment->id }}">
                                                @csrf
                                                <div class="flex justify-center mb-4">
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $payment->type_payment }}', '{{ $payment->id }}')"
                                                        class="px-5 py-2 mt-5 text-sm font-bold bg-blue-700 rounded text-gray-50">
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </form>
                                        </x-slot>
                                    </x-modal>
                                </x-tablas.td>
                            </x-tablas.tr>
                        @endforeach
                    </x-slot>
                </x-tablas.table>
            @endif
        </div>
    </div>
@endsection


<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(paymentDescription, paymentId) {
        Swal.fire({
            title: "Confirmación de Eliminación",
            html: "Recuerda que esta acción es irreversible y no podrás recuperar la información eliminada.<br><br>" +
                "Para confirmar, escribe la descripción del pago: <strong>" + paymentDescription + "</strong>",
            input: 'text',
            inputPlaceholder: 'Descripción del pago',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            icon: 'warning',
            preConfirm: (inputValue) => {
                if (inputValue !== paymentDescription) {
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
