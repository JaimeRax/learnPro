@extends('layouts.base')

@section('header')
    {{-- <x-route route="/" previousRouteName="Inicio" currentRouteName="clientes" /> --}}
@endsection

@section('main')

<x-modal id="delete{{ Str::random(16) }}" title="Estado de cuenta mensual"
         bstyle="border-none bg-green-600 text-white hover:bg-green-800 mt-8 w-full max-w-md p-6 rounded-lg shadow min-h-[5.5rem]">
    <x-slot name="button">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-center text-gray-900 dark:text-white">REPORTE DE CAJA MENSUAL</h5>
    </x-slot>

    <x-slot name="body">
        <form action="/report/reportPaymentsMonth" method="GET">
            @csrf
            <x-inputs.general titulo="Fecha de inicio" type="date" name="fecha_inicio" id="fecha_inicio" required />
            <x-inputs.general titulo="Fecha de finalizacion" type="date" name="fecha_fin" id="fecha_fin" required />
            <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">Generar PDF</button>
        </form>
    </x-slot>
</x-modal>

<div class="grid grid-cols-1 gap-2 mt-8">
    <a href="/report/reportPaymentsDiary"
       class="block max-w-md p-6 text-center text-white bg-blue-600 rounded-lg shadow hover:bg-blue-800">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-center text-gray-900 dark:text-white">REPORTE DE CAJA DIARIO</h5>
    </a>
</div>

@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
