@extends('layouts.base')

@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection

@section('main')
    <div class="grid grid-cols-1 gap-2">
        <a href="/report/reportPaymentsMonth"
            class="block max-w-sm p-6 rounded-lg shadow hover:bg-gray-100 dark:bg-orange-500 dark:border-orange-700 dark:hover:bg-orange-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">REPORTE DE CAJA MENSUAL</h5>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-2 mt-8">
        <a href="/report/reportPaymentsDiary"
            class="block max-w-sm p-6 text-center rounded-lg shadow hover:bg-gray-100 dark:bg-green-500 dark:border-green-700 dark:hover:bg-green-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-center text-gray-900 dark:text-white">REPORTE DE CAJA DIARIO</h5>
        </a>
    </div>

        <x-modal id="delete{{ Str::random(16) }}" title="Estado de cuenta mensual"
            bstyle="border-none bg-orange-600 text-white hover:bg-orange-800 mt-8">
            <x-slot name="button">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-center text-gray-900 dark:text-white">ESTADO GENERAL MENSUAL  </h5>
            </x-slot>

            <x-slot name="body">
                <form action="/report/reportStatusMonth" method="GET">
                    @csrf
                    <x-inputs.general titulo="Fecha de inicio" type="date" name="start_date" id="start_date" required />
                    <x-inputs.general titulo="Fecha de finalizacion" type="date" name="end_date" id="end_date" required />
                    <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">Generar PDF</button>
                </form>
            </x-slot>
        </x-modal>
@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
