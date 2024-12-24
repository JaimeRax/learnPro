@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="PAGOS" />
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">

        <div class="grid items-center justify-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">

            {{-- filtro por busqueda de nombre --}}
            <form class="input-group" action="/payments" method="get">
                <x-inputs.general id="search" name="search" placeholder="Busque por cualquier campo..."
                    value="{{ request()->query('search') }}" class="mt-14" />

                <div class="input-group-addon">
                    <button type="submit" class="input-group-text">
                        <i class="ti-search"></i>
                    </button>
                </div>
            </form>

            <form method="GET" action="/payments" id="degreeForm" class="flex items-center mt-6 space-x-4">

                <!-- filtro por grado -->
                <x-inputs.select-option id="degree_id" titulo="Grado:" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" :selected="request('degree_id')"
                    required onchange="document.getElementById('degreeForm').submit()" />

                <!-- filtro por seccion -->
                <x-inputs.select-option id="section_id" titulo="SECCIÓN" name="section_id" :options="$sections->pluck('name', 'id')->toArray()"
                    :selected="request('section_id')" required />

                <!-- Botón de Búsqueda -->
                <x-button type="submit" class="text-white mt-9 bg-blue-600">
                    <x-iconos.buscar />
                    BUSCAR
                </x-button>
            </form>
        </div>

        <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
            <x-slot name="thead">
                <x-tablas.tr>
                    <x-tablas.th>NO.</x-tablas.th>
                    <x-tablas.th>NOMBRE</x-tablas.th>
                    <x-tablas.th>GRADO</x-tablas.th>
                    <x-tablas.th>SECCIÓN</x-tablas.th>
                    <x-tablas.th>ACCIONES</x-tablas.th>
                </x-tablas.tr>
            </x-slot>

            @php
                $i = 1;
            @endphp

            <x-slot name="tbody">
                @foreach ($students as $student)
                    <x-tablas.tr>
                        <x-tablas.td>{{ $i++ }}</x-tablas.td>
                        <x-tablas.td>{{ strtoupper("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}") }}</x-tablas.td>
                        <x-tablas.td>{{ $student->degree_name ? strtoupper($student->degree_name) : '--- ----' }}</x-tablas.td>
                        <x-tablas.td>{{ $student->section_name ? strtoupper($student->section_name) : '--- ----' }}</x-tablas.td>
                        <x-tablas.td>
                            {{-- Botón de pagos --}}
                            <x-modal id="createPayment-{{ $student->id }}" title="PAGOS"
                                bstyle="border-none bg-green-600 text-white hover:bg-green-800">
                                <x-slot name="button">
                                    <div class="relative group">
                                        <x-iconos.pago />
                                        <div
                                            class="absolute bottom-full left-1/2 z-50 mb-2 hidden w-max rounded-md bg-white px-3 py-2 text-sm text-black shadow-lg group-hover:block transform -translate-x-1/2 font-normal">
                                            Realizar pago
                                        </div>
                                    </div>
                                </x-slot>
                                <x-slot name="body">
                                    @include('payments.newPayment', [
                                        'student' => $student,
                                        'user' => $users,
                                        'degree' => $degrees,
                                        'sections' => $sections,
                                        'collaborations' => $collaborations
                                    ])
                                </x-slot>
                            </x-modal>

                            {{-- Botón de listado de pagos --}}
                            <button onclick="window.location='{{ route('payments.listPaymentStudent', $student->id) }}'"
                                class="btn bg-cyan-600 hover:bg-cyan-800 text-white">
                                <div class="relative group">
                                    <x-iconos.listado />
                                    <div
                                        class="absolute bottom-full left-1/2 z-50 mb-2 hidden w-max rounded-md bg-white px-3 py-2 text-sm text-black shadow-lg group-hover:block transform -translate-x-1/2 font-normal">
                                        Historial de pagos
                                    </div>
                                </div>
                            </button>


                            @if (session('paid_student_id') == $student->id)
                                @if (session('show_assignment_button'))
                                    {{-- Botón de asignación --}}
                                    <x-button-link href="{{ url('assignment/student') }}"
                                        class="btn bg-yellow-400 hover:bg-yellow-600 text-white">
                                        <div class="relative group">
                                            <x-iconos.asignar />
                                            <div
                                                class="absolute bottom-full left-1/2 z-50 mb-2 hidden w-max rounded-md bg-white px-3 py-2 text-sm text-black shadow-lg group-hover:block transform -translate-x-1/2 font-normal">
                                                Asignar grado y sección
                                            </div>
                                        </div>
                                    </x-button-link>
                                @endif

                                @if (session('pdf_url') && session('payment_created'))
                                    {{-- Botón de descargar PDF --}}
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
                                @endif
                            @endif
                        </x-tablas.td>
                    </x-tablas.tr>
                @endforeach
            </x-slot>
        </x-tablas.table>
        <div>
            {{ $students->appends(['search' => request()->query('search')])->links('components.pagination') }}
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
