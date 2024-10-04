@extends('layouts.main')

@section('styles')
    <style>
        @page {
            margin: 1.5cm;
            line-height: 1;
            font-size: 10pt;
            text-align: justify;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .reduce-line-height {
            margin-bottom: 0.2rem;
        }

        .reduce-line-height-next {
            margin-top: 0.2rem;
        }

        .text-lg {
            font-size: 10pt;
        }
    </style>
@endsection

@section('content')
    <div class="container-sm">
        <h3 class="text-bold reduce-line-height">No. {{ $payment->id }}</h3>
        <p class="text-regular reduce-line-height-next">serie: {{ $payment->payment_uuid }}</p>

        <h2 class="text-center text-bold">INFORMACIÓN DE PAGO</h2>

        <table class="table text-lg">
            <tbody>
                <tr>
                    <td class="text-bold">Fecha de documento</td>
                    <td class="text-right text-regular">{{ $payment->transaction_date }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Nombre cliente</td>
                    <td class="text-right text-regular">{{ $client->primer_nombre }} {{ $client->segundo_nombre }}
                        {{ $client->primer_apellido }} {{ $client->segundo_apellido }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Tipo de pago</td>
                    <td class="text-right text-regular">{{ $payment_type->name }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Metodo de pago</td>
                    <td class="text-right text-regular">Depocito/Tranferencia</td>
                </tr>
                <tr>
                    <td class="text-bold">Total de abonado</td>
                    <td class="text-right text-regular">{{ Utils::money($payment->transaction_total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    @include('styles.partials.footer', [
        'uuid' => $uuid,
        'date' => $date,
        'name' => $name
    ])
@endsection
