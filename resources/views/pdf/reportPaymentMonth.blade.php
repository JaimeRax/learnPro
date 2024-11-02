@extends('components.template.payments')

@section('title', 'Contenido del Voucher')

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
        font-size: 14px;
        background: #3a3d42;
        color: #FFFFFF;
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .nameColumn {
        background: #1d97e8;
        color: white;
        font-weight: 500;
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

    td,
    th {
        font-size: 11px;
        border-bottom: 1px solid #e1e4e8;
        padding: 10px;
        text-align: left;
    }

    th {
        font-weight: 500;
        text-transform: uppercase;
    }

    tbody tr:nth-child(even) {
        background-color: #ececec;
    }

    tbody tr:hover {
        background-color: #f1f5f9;
    }

    .total {
        text-align: right;
        font-weight: bold;
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
        font-size: 12px;
        font-weight: 500;
        color: #3a3d42;
        text-align: left;
        margin-top: 10px;
        margin-bottom: 20px;
    }
</style>

@section('content')
    @include('styles.partials.title', ['title' => 'Corte de Caja Mensual'])
    <h1 style="margin: 0;">Desde: {{ $fecha_inicio }}</h1>
    <h1 style="margin: 0;">Hasta: {{ $fecha_fin }}</h1>


    <div style="padding: 10px; background-color: #fff; border-radius: 8px; margin: 10px 0;">
        <!-- Primera Tabla -->
        <h3 style="text-align: center; font-size: 15px;" class="roboto-thin">Detalles de Cuotas Pagadas</h3>
        <table>
            <thead>
                <tr class="nameColumn">
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Grado</th>
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Sección</th>
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Cuotas Pagadas</th>
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resultados as $result)
                    <tr>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">{{ strtoupper($result->degree_name) }}</td>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">{{ strtoupper($result->section_name) }}</td>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">{{ $result->total_records }}</td>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Q.{{ number_format($result->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Segunda Tabla -->
        <h3 style="text-align: center; font-size: 15px; margin-top: 80px;" class="roboto-thin">Totales por grado</h3>
        <table style="margin-top: 10px;">
            <thead>
                <tr class="nameColumn">
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Grado</th>
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Total Cuotas Pagadas</th>
                    <th class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalesPorGrado as $grado => $totales)
                    <tr>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">{{ strtoupper($grado) }}</td>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">{{ $totales['total_records'] }}</td>
                        <td class="roboto-thin" style="text-align: center; padding: 5px; border: 1px solid #ddd;">Q.{{ number_format($totales['total_amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
