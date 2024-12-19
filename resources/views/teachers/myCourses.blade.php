@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection

@section('main')
<div class="grid items-center grid-cols-1 gap-2 md:grid-cols-3 lg:flex">
    <form method="GET" action="/teachers/myCourses" id="degreeForm" class="mt-6">
        <x-inputs.select-option
            id="degrees_id"
            titulo="Seleccione un grado"
            name="degrees_id"
            :options="$degrees->pluck('name', 'id')->toArray()"
            :selected="$selectedDegreeId"
            required
            onchange="document.getElementById('degreeForm').submit()"
        />
    </form>
</div>

<div class="grid grid-cols-1 gap-2">
    <x-tablas.table wire:loading.remove id="table" data-name="ReporteClientes">
        <x-slot name="thead">
            <x-tablas.tr>
                <x-tablas.th>No.</x-tablas.th>
                <x-tablas.th>Curso</x-tablas.th>
                <x-tablas.th>Grado</x-tablas.th>
                <x-tablas.th>Sección</x-tablas.th>
            </x-tablas.tr>
        </x-slot>
        @php $i = 1; @endphp

        <x-slot name="tbody">
            @foreach ($courses as $item)
                <x-tablas.tr>
                    <x-tablas.td>{{ $i++ }}</x-tablas.td>
                    <x-tablas.td class="py-2">{{ strtoupper($item['course']->name) }}</x-tablas.td>
                    <x-tablas.td class="py-2">{{ strtoupper(optional($item['degree'])->name) }}</x-tablas.td>
                    <x-tablas.td class="py-2">{{ strtoupper(optional($item['section'])->name) }}</x-tablas.td>
                </x-tablas.tr>
            @endforeach
        </x-slot>

        <x-alert-message />
    </x-tablas.table>
</div>
@endsection
