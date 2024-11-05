@extends('components.template.payments')

@section('title', 'Calificaciones')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&family=Roboto:wght@100;400&display=swap');

    .roboto-light {
        font-family: "Roboto", sans-serif;
        font-weight: 300;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        color: #2c2e35;
        margin: 0;
        padding: 0;
    }
    @media print {
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: white;
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #000;
        z-index: 1000;
        height: 60px; /* Ajusta según el tamaño del encabezado */
    }
    .content,
    table {
        margin-top: 250px; /* Ajustar según el tamaño del encabezado */
    }
}

    .page-break {
        page-break-after: always;
        margin-top: 60px; /* Ajustar el espacio al principio de cada página */
    }



    .titulo {
        text-align: center;
        font-size: 10px;
        background: #3a3d42;
        color: #FFFFFF;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .nameColumn {
        background: #1866c6;
        color: white;
        font-weight: 500;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
    }

    table {
        width: 100%;
        background-color: #FFFFFF;
        color: #4a4a4a;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border-collapse: collapse;
        margin-bottom: 20px;
        page-break-inside: avoid; /* Evitar romper la tabla dentro */
    }

    th {
        font-size: 8px;
        background-color: #0b3f62;
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
    }

    td {
        font-size: 8px;
        padding: 6px;
        text-align: center;
        border-bottom: 1px solid #e1e4e8;
    }

    tbody tr:nth-child(even) {
        background-color: #e5e3e3;
    }

    tbody tr:hover {
        background-color: #f1f5f9;
    }

    .total {
        text-align: center;
        font-weight: bold;
        background-color: #f0f2f4;
    }

    .voucher {
        width: 100%;
        padding: 15px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 10px;
        font-weight: 600;
        color: #2c2e35;
        border-left: 5px solid #1866c6;
        padding-left: 15px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: #2c2e35;
        border-left: 5px solid #1866c6;
        padding-left: 15px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .page-break {
        page-break-after: always; /* Asegúrate de que haya un salto de página después */
    }
</style>

@section('content')

    @include('styles.partials.title', ['title' => 'Calificaciones'])

    @foreach ($results as $key => $activities)
        @php
            $parts = explode('-', $key);
            $grado = $parts[0] ?? 'Desconocido';
            $seccion = $parts[1] ?? 'Desconocida';
            $curso = $parts[2] ?? 'Desconocido';
        @endphp

        <!-- Encabezado que se repetirá para cada tabla -->
        <h1 style="margin: 0;">DOCENTE: {{ strtoupper($fullName) }} </h1>
        <h2 style="margin: 0;">{{ strtoupper("{$grado} {$seccion}  {$curso}") }} </h2>

        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    @foreach (array_keys($activities[array_key_first($activities)]['actividades'] ?? []) as $actividad)
                        <th>{{ $actividad }}</th>
                    @endforeach
                    <th>Calificación Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $studentActivity)
                    <tr>
                        <td>{{ $studentActivity['estudiante'] }}</td> <!-- Nombre del estudiante -->

                        @foreach (array_keys($activities[array_key_first($activities)]['actividades'] ?? []) as $actividad)
                            <td>{{ $studentActivity['actividades'][$actividad] ?? '-' }}</td>
                            <!-- Calificaciones -->
                        @endforeach

                        <td>{{ array_sum($studentActivity['actividades'] ?? []) }}</td>
                        <!-- Suma de calificaciones -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div> <!-- Saltar a la siguiente página -->
    @endforeach
@endsection
