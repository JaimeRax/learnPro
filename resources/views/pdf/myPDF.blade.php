@extends('components.template.payments')

@section('title', 'Contenido del Voucher')
<style>
    @page {
        margin-top: 1cm;
        margin-left: 1.5cm;
        margin-bottom: 1cm;
        margin-right: 1.5cm;
        font-size: 12px;
        font-family: 'Montserrat', sans-serif;
    }

    .titulo {
        text-align: center;
        font-size: 12px;
        background: #151819;
        color: #FFFFFF;
        height: 20px;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    .nameColumn {
        background: #151819;
        color: white;
        line-height: 20px;
    }

    table {
        width: 100%;
        background-color: #FFFFFF;
        color: #2c2e35;
        text-align: center;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    td,
    th {
        height: 18px;
        font-weight: normal;
        text-transform: capitalize;
        font-size: 9px;
        border: 1px solid #2c2e35;
    }

    .campo {
        font-weight: bold;
        padding-top: 3px;
    }

    .content {
        font-size: 9px;
        text-align: left;
        padding-left: 5px;
        line-height: 1.2;
    }


    .hr-firma {
        margin-top: 15px;
    }

    .voucher {
        width: 100%;
        border: 1px solid #2c2e35;
        padding: 5px;
        margin-bottom: 20px;
    }

    .page-break {
        page-break-after: always;
    }
</style>

@section('content')
    @include('styles.partials.title', [
        'title' => 'ESTADO DE CUENTA PARA FINIQUITO'
    ])
    @if ($payments->first()->type_payment === 'mensualidad')
        @foreach ($payments as $pays)
            <div class="voucher">

                <div style=" font-size: 0.8rem;">
                    <p class=" lato-bold">No. </p>
                </div>
                <h4 class="titulo" style=" font-size: 0.7rem;">
                    Datos Generales del Pago
                </h4>
                <table class="table mt-5 table-offset" style=" margin-top: 10px;">
                    <thead>
                        <tr>
                            <th scope="col" style=" font-size: 0.5rem;">Cuota Escolar Mensual</th>
                            <th scope="col" style=" font-size: 0.5rem;">Couta Computaciòn Mneusal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style=" font-size: 0.6rem;">Q55.00</td>
                            <td style=" font-size: 0.6rem;">q20.00</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <div style="flex-direction: column;">
                        <div style="flex-direction:row; margin-top: 15px;">
                            <span class="campo" style=" font-size: 0.8rem;">Nombre:</span>
                            <span class="content" style="width:35.5%">
                                {{ $student->first_lastname }} {{ $student->second_lastname }}
                                {{ $student->first_name }}
                                {{ $student->second_name }}
                            </span>
                            <span class="campo" style=" font-size: 0.8rem; margin-left: 35.5px;">Fecha:</span>
                            <span class="content" style="width:41.5%">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
                        </div>
                        <div style="flex-direction:row; margin-top: 1px;">
                            <span class="campo" style=" font-size: 0.8rem;">Grado:</span>
                            <span class="content" style="width:37% "> primero quemado </span>
                            <span class="campo" style="font-size: 0.8rem; margin-left: 35.3px;"> A quemado
                            </span>
                            <span class="content" style="width:40%"> A </span>
                        </div>
                        <div style="flex-direction:row; margin-top: 1px;">
                            <span class="campo" style="font-size: 0.8rem;">Mes de pago: </span>
                            <span class="content" style="width:31%"> {{ $pays->paid_month }} </span>
                            <span class="campo" style=" font-size: 0.8rem; margin-left: 31px;"> Tipo de
                                pago:</span>
                            <span class="content" style="width:35.8%"> {{ $pays->type_payment }}</span>
                        </div>
                        <div style="flex-direction:row; margin-top: 10px;">
                            <span class="campo" style=" font-size: 0.8rem;"> Observaciones</span>
                            <span class="content" style="width:84.2%; font-size: 0.8rem;"> {{ $pays->comment }}
                            </span>
                        </div>
                        <div style="flex-direction:row; margin-top: 10px;">
                            <span class="campo" style=" font-size: 0.8rem;"> Total:</span>
                            <span class="" style="width:94.5%; font-size: 0.7rem;"> Q. {{ $pays->amount }}
                            </span>
                        </div>
                        <div class="mt-3 mb-3 text-center">
                            <div>
                                <hr class="hr-firma" style="width: 50%;">
                                <p style=" margin-left: 280px; font-size: 0.7rem;">Firma de Direcciòn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($loop->iteration % 2 == 0)
                <div class="page-break"></div>
            @endif
        @endforeach
    @else
        <div class="voucher">

            <h4 class="titulo">Datos Generales del Pago</h4>
            <div>
                <p><span class="campo">Nombre:</span> <span class="content">{{ $student->first_lastname }}
                        {{ $student->second_lastname }} {{ $student->first_name }}
                        {{ $student->second_name }}</span></p>
                <p><span class="campo">Grado:</span> <span class="content">{{ $student->grade }}
                        {{ $student->section }}</span></p>
                <p><span class="campo">Fecha:</span> <span
                        class="content">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span></p>
                <p><span class="campo">Tipo de pago:</span> <span
                        class="content">{{ $payments->first()->type_payment }}</span></p>
                <p><span class="campo">Observaciones:</span> <span
                        class="content">{{ $payments->first()->comment }}</span></p>
                <p><span class="campo">Total:</span> <span class="content">Q.
                        {{ $payments->first()->amount }}</span></p>
            </div>
        </div>
    @endif
@endsection
