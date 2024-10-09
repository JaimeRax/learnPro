<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Solicitud de Financiamiento</title>
        <style>
            @page {
                margin-top: 1cm;
                margin-left: 1.8cm;
                margin-bottom: 1cm;
                margin-right: 1.8cm;
                line-height: 1.5;
                font-size: 12;
                text-align: justify;
                font-weight: bold;
                font-family: 'Montserrat', sans-serif;
                color: #2c2e35;
            }

            .titulo {
                text-align: center;
                font-size: 14;
                background: #151819;
                color: #FFFFFF;
                text-align: center;
                height: 22px;
                border-radius: 3px;
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
                border-collapse: separate;
                border-spacing: 0;
                border: 1px solid #2c2e35;
                border-radius: 11px;
            }

            td {
                height: 20px;
                font-weight: normal;
                text-transform: capitalize;
            }

            .col1 {
                border-top: 0.5px solid #2c2e35;
                vertical-align: middle;
            }

            .col2 {
                border-right: 0.5px solid #2c2e35;
                border-left: 0.5px solid #2c2e35;
                border-top: 0.5px solid #2c2e35;
                width: 30%;
            }

            .campo {
                font-weight: bold;
                line-height: 1;
                border-bottom: 1px;
                display: inline-block;
                padding-top: 8px;
            }

            .encabezado {
                width: 60%;
                float: right;
                text-align: right;
                font-size: 22px;
                padding-top: 7px;
                font-weight: bold;
                font-family: 'Montserrat', sans-serif;
            }

            .content {
                border-bottom: 0.7px solid #2c2e35;
                display: inline-block;
                font-size: 0.8rem;
                line-height: 1;
                text-align: center;
                padding-top: 8px;
                font-weight: normal;
                /* Esto asegura que el texto no esté en negrita */
            }


            .header {
                line-height: 0.3;
            }

            .logo {
                width: 60px;
                display: inline-block;
                vertical-align: middle;
                margin-top: -10;
            }

            .title {
                font-size: 18px;
                vertical-align: middle;
                display: inline-block;
            }

            .contact-info {
                float: right;
                /* Mantiene el flotado a la derecha */
                text-align: right;
                /* Alinea el texto a la derecha */
                font-size: 0.5rem;
                /* Tamaño de fuente más pequeño */
                line-height: 0.5;
                /* Reduce el espacio entre líneas */
                margin: 0;
                /* Elimina márgenes si los hay */
                padding: 0;
                /* Elimina padding si es necesario */
            }


            .text-container {
                display: inline-block;
                /* Mantiene el comportamiento de inline-block */
                vertical-align: middle;
                /* Alinea verticalmente al medio */
                font-size: 0.6rem;
                /* Ajusta el tamaño de fuente a un valor más pequeño */
                line-height: 0.7;
                /* Reduce el espaciado entre líneas */
                margin: 0;
                /* Elimina márgenes si los hay */
                padding: 0;
                /* Elimina padding si es necesario */
            }

            .text-container .title {
                display: inline-block;
                /* Mantiene el comportamiento de inline-block */
                vertical-align: middle;
                /* Alinea verticalmente al medio */
                font-size: 0.5rem;
                /* Ajusta el tamaño de fuente a un valor más pequeño */
                line-height: 1.1;
                /* Reduce el espaciado entre líneas */
                margin: 0;
                /* Elimina márgenes si los hay */
                padding: 0;
                /* Elimina padding si es necesario */
            }

            .hr-firma {
                margin-top: 4rem;
            }
        </style>
    </head>

    <body>

        @foreach ($payments as $dato)
            <div class="header" style=" margin-top: 30px;">
                <div class="contact-info lato-regular">
                    <p>4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché San Juan Chamelco Alta Verapaz</p>
                    <p>institutobasicojv.chamelco@gmail.com</p>
                    <p>Tel. (+502) 5991 0548</p>
                </div>
                <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />

                <div class="text-container ">
                    <p class=" lato-bold">INSTITUTO DE EDUCACION BASICA </p>
                    <p class=" lato-bold">POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
                    <p class="lato-regular-italic">Autorizado por Acuerdo Ministerial NO. 475</p>
                </div>

            </div>
            <div style=" font-size: 0.8rem;">
                <p class=" lato-bold">No. 000001</p>
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

            <div style="flex-direction: column;">
                <div style="flex-direction:row; margin-top: 15px;">
                    <span class="campo" style=" font-size: 0.8rem;">Nombre:</span>
                    <span class="content" style="width:35.5%">
                        {{ $dato->first_lastname }} {{ $dato->second_lastname }} {{ $dato->first_name }}
                        {{ $dato->second_name }}
                    </span>
                    <span class="campo" style=" font-size: 0.8rem; margin-left: 35.5px;">Fecha:</span>
                    <span class="content" style="width:41.5%">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>

                </div>

                <div style="flex-direction:row; margin-top: 1px;">
                    <span class="campo" style=" font-size: 0.8rem;">Grado:</span>
                    <span class="content" style="width:37% ">{{ $dato->degree->name }}</span>
                    <span class="campo" style="font-size: 0.8rem; margin-left: 35.3px;"> {{ $dato->section->name }}
                    </span>
                    <span class="content" style="width:40%"> A </span>

                </div>
                @foreach ($pay as $pays)
                    <div style="flex-direction:row; margin-top: 1px;">

                        <span class="campo" style="font-size: 0.8rem;">Mes de pago: </span>
                        <span class="content" style="width:31%"> Enero </span>
                        <span class="campo" style=" font-size: 0.8rem; margin-left: 31px;"> Tipo de pago:</span>
                        <span class="content" style="width:35.8%"> {{ $pays->type_payment }}</span>
                    </div>

                    <div style="flex-direction:row; margin-top: 10px;">

                        <span class="campo" style=" font-size: 0.8rem;"> Observaciones</span>
                        <span class="content" style="width:84.2%; font-size: 0.8rem;"> {{ $pays->comment }} </span>
                    </div>



                <div style="flex-direction:row; margin-top: 10px;">

                    <span class="campo" style=" font-size: 0.8rem;"> Total:</span>
                    <span class="" style="width:94.5%; font-size: 0.7rem;"> Q. {{ $pays->amount }} </span>
                </div>
                @endforeach
        @endforeach
        <div class="mt-3 mb-3 text-center">
            <div>
                <hr class="hr-firma" style="width: 50%;">
                <p style=" margin-left: 280px; font-size: 0.7rem;">Firma de Direcciòn</p>

            </div>
        </div>
        </div>


    </body>


</html>
