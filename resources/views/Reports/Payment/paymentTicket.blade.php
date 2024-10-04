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
        <h3 class="text-bold reduce-line-height">No. 000</h3>
        <p class="text-regular reduce-line-height-next">serie: 23kfasfwo233l2rj2</p>

        <h2 class="text-center text-bold">INFORMACIÓN DE PAGO</h2>

        <table class="table text-lg">
            <tbody>
                <tr>
                    <td class="text-bold">Fecha de documento</td>
                    <td class="text-right text-regular">04/10/2024</td>
                </tr>
                <tr>
                    <td class="text-bold">Nombre cliente</td>
                    <td class="text-right text-regular">Jaime Rax</td>
                </tr>
                <tr>
                    <td class="text-bold">Tipo de pago</td>
                    <td class="text-right text-regular">Pago Mensualidad</td>
                </tr>
                <tr>
                    <td class="text-bold">Metodo de pago</td>
                    <td class="text-right text-regular">Depocito/Tranferencia</td>
                </tr>
                <tr>
                    <td class="text-bold">Total de abonado</td>
                    <td class="text-right text-regular">Q 75.00</td>
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
