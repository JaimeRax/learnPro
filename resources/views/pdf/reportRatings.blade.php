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
        page-break-after: always;
    }
</style>

@section('content')
    @include('styles.partials.title', ['title' => 'Calificaciones'])

    <h1 style="margin: 0;">DOCENTE: {{ strtoupper($fullName) }} </h1>
    <h2 style="margin: 0;">{{ strtoupper("{$gradoNombre} {$seccionNombre}  {$cursoNombre}") }} </h2>



    <div style="padding: 15px; background-color: #fff; border-radius: 8px; margin: 15px 0;">
        <!-- Tabla de Calificaciones -->
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    @foreach ($activities as $activity)
                        <th>{{ $activity->name }}</th>
                    @endforeach
                    <th>Nota Final</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->first_name }} {{ $student->last_name }} {{ $student->first_lastname }} {{ $student->second_lastname }}</td>
                        @php $totalScore = 0; @endphp
                        @foreach ($activities as $activity)
                            @php
                                $score = $ratings[$student->id][$activity->id]->score_obtained ?? 0;
                                $totalScore += $score;
                            @endphp
                            <td>{{ $score }}</td>
                        @endforeach
                        <td class="total">{{ $totalScore }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    @if (isset($resultados) && count($resultados ?? []) % 2 == 0)
        <div class="page-break"></div>
    @endif
@endsection
