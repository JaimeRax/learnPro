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
        background-color: #f9fafb;
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
    @include('styles.partials.title', ['title' => 'Reporte de Corte de Caja Mensual'])
    <h1> Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h1>
    <h1> Recibo:  </h1>
    <div class="voucher">
        <table>
            <thead>
                <tr class="nameColumn">
                    <th class="roboto-light">Grado</th>
                    <th class="roboto-light">Sección</th>
                    <th class="roboto-light" style="text-align: center;">Cuotas Pagadas</th>
                    <th class="roboto-light" style="text-align: right;">Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td class="roboto-light">{{ $payment->degree }}</td>
                        <td class="roboto-light">{{ $payment->section }}</td>
                        <td class="roboto-light" style="text-align: center;">{{ $payment->cuotas }}</td>
                        <td class="roboto-light total">{{ number_format($payment->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection
