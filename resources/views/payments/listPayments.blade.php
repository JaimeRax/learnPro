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
                            {{-- Botón de asignación --}}
                            @if(session('show_assignment_button'))
                                <button id="assignmentButton" class="px-4 py-2 mt-2 text-white bg-green-500 rounded" onclick="handleAssignment()">
                                    Asignar
                                </button>
                            @endif

                            {{-- Botón de descargar PDF --}}
                            <button id="downloadPdfButton" class="px-4 py-2 mt-2 text-white bg-red-500 rounded" onclick="handleDownloadPDF()">
                                Descargar PDF
                            </button>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Mostrar u ocultar el botón de asignación según el valor de sesión
            const assignmentButton = document.getElementById("assignmentButton");
            const downloadPdfButton = document.getElementById("downloadPdfButton");

            if (assignmentButton) {
                assignmentButton.style.display = '{{ session("show_assignment_button") ? "block" : "none" }}';
            }
        });

        function handleAssignment() {
            // Oculta el botón de asignación después de hacer clic
            const assignmentButton = document.getElementById("assignmentButton");
            if (assignmentButton) {
                assignmentButton.style.display = "none";
            }

            swal({
                title: "Asignación realizada",
                text: "La asignación se completó exitosamente.",
                icon: "success",
                button: "OK",
            });
        }

        function handleDownloadPDF() {
            // Lógica para descargar el PDF
            // Ejemplo: window.location.href = 'ruta/al/pdf';

            // Oculta el botón de descarga de PDF después de hacer clic
            const downloadPdfButton = document.getElementById("downloadPdfButton");
            if (downloadPdfButton) {
                downloadPdfButton.style.display = "none";
            }

            swal({
                title: "Descarga iniciada",
                text: "El PDF se está descargando.",
                icon: "success",
                button: "OK",
            });
        }
    </script>
