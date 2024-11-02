<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recibo de Pago</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                display: flex;
                justify-content: center;
            }

            .container {
                width: 90%;
                border: 1px solid #ccc;
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .header {
                line-height: 0.3;
                padding-bottom: 5px;
                border-bottom: 1px solid #ddd;
            }

            .contact-info {
                float: right;
                text-align: right;
                font-size: 0.5rem;
                line-height: 0.5;
                margin: 0;
                padding: 0;
            }

            .logo {
                width: 110px;
                display: inline-block;
                vertical-align: middle;
                margin-top: -15px;
            }

            .text-container {
                display: inline-block;
                vertical-align: middle;
                font-size: 10px;
                line-height: 0.2;
                margin: 0;
                padding: 0;
            }

            .text-container .title {
                display: inline-block;
                vertical-align: middle;
                font-size: 0.5rem;
                line-height: 0.5;
                margin: 0;
                padding: 0;
            }

            .receipt-number {
                text-align: center;
                display: inline-block;
                font-weight: bold;
                font-size: 16px;
                border: 1px solid #000;
                {{-- padding: 10px; --}} width: 20%;
                border-radius: 10px;
            }

            .section-title {
                text-align: center;
                background-color: #2c3e50;
                color: #fff;
                padding: 8px;
                font-weight: bold;
                font-size: 14px;
                margin: 15px 0;
                border-radius: 5px;
            }

            .content {
                font-size: 14px;
                line-height: 1.6;
            }

            .field {
                margin: 10px 0;
            }

            .field span {
                display: inline-block;
            }

            .field p {
                display: inline-block;
            }

            .field-value {
                display: inline-block;
                margin-left: 10px;
                color: #333;
            }

            .signature {
                margin-top: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }


            .total {
                font-size: 14px;
                font-weight: bold;
                text-align: right;
                color: red;
            }

            .footer {
                text-align: center;
                font-size: 10px;
                margin-top: 15px;
                color: #666;
            }
        </style>
    </head>
    <body>
        @php
            function getMonthName($monthNumber)
            {
                $months = [
                    1 => 'ENERO',
                    2 => 'FEBRERO',
                    3 => 'MARZO',
                    4 => 'ABRIL',
                    5 => 'MAYO',
                    6 => 'JUNIO',
                    7 => 'JULIO',
                    8 => 'AGOSTO',
                    9 => 'SEPTIEMBRE',
                    10 => 'OCTUBRE'
                ];

                return $months[$monthNumber] ?? '---'; // Para números fuera del rango
            }
        @endphp
        @if ($payments->first()->type_payment === 'mensualidad')
            @foreach ($payments as $pays)
                <div class="container">
                    <div class="header">
                        <div class="contact-info">
                            <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />
                        </div>
                        <div class="text-container">
                            <p>INSTITUTO DE EDUCACION BASICA POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
                            <p>AUTORIZADO POR EL ACUERDO MINISTERIAL No. 475</p>
                            <p>4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché</p>
                            <p>San Juan Chamelco, Alta Verapaz</p>
                            <p>institutobasicojv.chamelco@gmail.com</p>
                            <p>Tel. (+502) 5991 0548</p>
                        </div>
                    </div>

                    <div class="section-title">DATOS DEL ESTUDIANTE</div>
                    <div class="content">
                        <div class="field">
                            <span><strong>Nombre: </strong>{{ $student->first_lastname }}
                                {{ $student->second_lastname }}
                                {{ $student->first_name }} {{ $student->second_name }}</span>
                            <span style="float: right;"><strong>Grado: </strong>{{ $student->degree_name }}
                                {{ $student->section_name }}</span>
                        </div>
                    </div>

                    <div class="section-title">DETALLES DEL PAGO</div>
                    <div class="content">
                        <div class="field">
                            <span><strong>Tipo Pago: </strong>
                                {{ $pays->type_payment }}</span>
                            <span style="float: right;"><strong>Fecha pago: </strong>
                                {{ $pays->payment_date }}</span>
                        </div>
                        <div class="field">
                            <span><strong>Método Pago: </strong>
                                {{ $pays->mood_payment }}</span>
                            <span style="float: right;"><strong>Mes a pagar: </strong>
                                {{ getMonthName($pays->paid_month) }}</span>
                        </div>
                        <div class="field">
                            <span><strong>Observaciones: </strong>
                                {{ $pays->comment }}</span>
                        </div>
                    </div>

                    <div class="signature">
                        <div class="signature-line">f.____________________</div>
                        <div class="total">Total pagado: Q {{ $pays->amount }}</div>
                    </div>

                    <div class="footer">
                        {{ $username }} - {{ $pays->uuid }} -
                        {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                    </div>
                    @if ($loop->iteration % 2 == 0)
                        <div class="page-break"></div>
                    @endif
                </div>
                <br>
            @endforeach
        @else
            <div class="container">
                <div class="header">
                    <div class="contact-info">
                        <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />
                    </div>
                    <div class="text-container">
                        <p>INSTITUTO DE EDUCACION BASICA POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
                        <p>AUTORIZADO POR EL ACUERDO MINISTERIAL No. 475</p>
                        <p>4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché</p>
                        <p>San Juan Chamelco, Alta Verapaz</p>
                        <p>institutobasicojv.chamelco@gmail.com</p>
                        <p>Tel. (+502) 5991 0548</p>
                    </div>
                </div>

                <div class="section-title">DATOS DEL ESTUDIANTE</div>
                <div class="content">
                    <div class="field">
                        <span><strong>Nombre: </strong>{{ $student->first_lastname }}
                            {{ $student->second_lastname }}
                            {{ $student->first_name }} {{ $student->second_name }}</span>
                        <span style="float: right;"><strong>Grado: </strong>{{ $student->degree_name }}
                            {{ $student->section_name }}</span>
                    </div>

                    <div class="section-title">DETALLES DEL PAGO</div>
                    <div class="content">
                        <div class="field">
                            <span><strong>Tipo Pago: </strong>
                                {{ $singlePayment->type_payment }}</span>
                            <span style="float: right;"><strong>Fecha pago: </strong>
                                {{ $singlePayment->payment_date }}</span>
                        </div>
                        <div class="field">
                            <span><strong>Método Pago: </strong>
                                {{ $singlePayment->mood_payment }}</span>
                            <span style="float: right;"><strong>Mes a pagar: </strong>
                                {{ getMonthName($singlePayment->paid_month) }}</span>
                        </div>
                        <div class="field">
                            <span><strong>Observaciones: </strong>
                                {{ $singlePayment->comment }}</span>
                        </div>
                    </div>

                    <div class="signature">
                        <div class="signature-line">f.____________________</div>
                        <div class="total">Total pagado: Q {{ $singlePayment->amount }}</div>
                    </div>

                    <div class="footer">
                        {{ $username }} - {{ $singlePayment->uuid }} -
                        {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                    </div>
        @endif
    </body>
</html>
