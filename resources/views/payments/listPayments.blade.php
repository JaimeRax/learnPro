@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/payments" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-6" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            {{-- filtro por seleccion de grado --}}
            <form method="GET" action="/payments" id="degreeForm" class="mt-6">
                <x-inputs.select-option id="degree_id" titulo="" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required onchange="document.getElementById('degreeForm').submit()" />
            </form>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>No.</x-tablas.th>
                    <x-tablas.th>Nombre</x-tablas.th>
                    <x-tablas.th>Grado</x-tablas.th>
                    <x-tablas.th>Sección</x-tablas.th>
                    <x-tablas.th>Acciones</x-tablas.th>
                </x-tablas.tr>
            </x-slot>
            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($student as $studens)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>{{ $studens->section_id ? strtoupper($studens->section_id) : '--- ----' }}</x-tablas.td>
                        <x-tablas.td>{{ $studens->degree_id ? strtoupper($studens->section_id) : '--- ----' }}</x-tablas.td>
                        <x-tablas.td>
                            {{-- Botón de pagos --}}
                            <x-modal id="createPayment-{{ $studens->id }}" title="PAGOS"
                                bstyle="border-none bg-blue-600 text-white hover:bg-blue-800">
                                <x-slot name="button">
                                    <x-iconos.pago />
                                </x-slot>
                                <x-slot name="body">
                                    @include('payments.newPayment', [
                                        'student' => $studens,
                                        'user' => $users,
                                        'degree' => $degrees,
                                        'sections' => $sections,
                                        'collaborations' => $collaborations
                                    ])
                                </x-slot>
                            </x-modal>

                            {{-- Botón de listado de pagos --}}
                            <button onclick="window.location='{{ route('payments.listPaymentStudent', $studens->id) }}'"
                                class="btn btn-success">
                                <i class="fas fa-list"></i> <!-- Ícono de listado -->
                            </button>


                            {{-- Botón de asignación --}}
                            @if (session('show_assignment_button'))
                                <a href="{{ url('assignment/student') }}" class="btn btn-success">
                                    Asignar
                                </a>
                            @endif

                            {{-- Botón de descargar PDF --}}
                            @if (session('pdf_url') && session('payment_created'))
                                <button onclick="window.open('{{ session('pdf_url') }}', '_blank');" class="btn btn-danger">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            @endif
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>
        <div>
            {{ $student->appends(['search' => request()->query('search')])->links('components.pagination') }}
        </div>
    @endsection


    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function redirectToAssignment(studentId) {
            // Redirige a la página de asignación para el estudiante
            window.location.href = `/assignment/student/`;
        }

        function downloadPDF(pdfUrl) {
            // Redirige a la URL del PDF para descarga
            window.location.href = pdfUrl;

            // Desactivar el botón de descarga después de hacer clic
            document.getElementById('downloadPdfButton').disabled = true;
            document.getElementById('downloadPdfButton').classList.add('opacity-50'); // Cambia el estilo si lo deseas
        }
    </script>
