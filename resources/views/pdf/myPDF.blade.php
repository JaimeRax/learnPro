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
                vertical-align: top;
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
                font-weight: normal;
                line-height: 1;
                text-align: center;
                padding-top: 8px;
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
        </style>
    </head>

    <body>

        @foreach ($payments as $dato)
            <div class="header" style=" margin-top: 30px;">
                <div class="contact-info lato-regular" >
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


            <h4 class="titulo" style="margin-bottom:5px; margin-top: 40px;">
                Datos Generales del Pago
            </h4>

            <table class="table mt-5 table-offset" style=" margin-top: 15px;">
                <thead>
                    <tr>
                        <th scope="col" style=" font-size: 0.7rem;">Cuota Escolar Mensual</th>
                        <th scope="col" style=" font-size: 0.7rem;">Couta Computaciòn Mneusal</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style=" font-size: 0.7rem;">Q55.00</td>
                        <td style=" font-size: 0.7rem;">q20.00</td>


                    </tr>
                </tbody>
            </table>

            <div style="flex-direction: column;">
                <div style="flex-direction:row; margin-top: 25px;">
                    <span class="campo" style=" font-size: 0.7rem;">Nombre:</span>
                    <span class="content" style="width:92%">
                        {{ $dato->first_lastname }} {{ $dato->second_lastname }} {{ $dato->first_name }}
                        {{ $dato->second_name }}
                    </span>


                </div>

                <div style="flex-direction:row; margin-top: 5px;">
                    <span class="campo" style=" font-size: 0.7rem;">Fecha:</span>
                    <span class="content" style="width:93.5%">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>

                </div>
                <div style="flex-direction:row; margin-top: 5px;">

                    <span class="campo" style="font-size: 0.7rem;">Metodo de pago: </span>
                    <span class="content" style="width:85.5%"> Efectivo </span>
                </div>
                <div style="flex-direction:row; margin-top: 5px;">

                    <span class="campo" style=" font-size: 0.7rem;"> Tipo de pago:</span>
                    <span class="content" style="width:88%"> Mensualidad </span>
                </div>



                <div style="flex-direction:row; margin-top: 30px;">

                    <span class="campo" style=" font-size: 0.7rem;"> Total:</span>
                    <span class="" style="width:94.5%"> Q. {{ $dato->personal_code }} </span>
                </div>


            </div>
        @endforeach

        @foreach ($payments as $dato)
        <div class="header" style=" margin-top: 150px;">
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


        <h4 class="titulo" style="margin-bottom:5px; margin-top: 50px;">
            Datos Generales del Pago
        </h4>

        <table class="table mt-5 table-offset" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col" style=" font-size: 0.7rem;">Cuota Escolar Mensual</th>
                    <th scope="col" style=" font-size: 0.7rem;">Couta Computaciòn Mneusal</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style=" font-size: 0.7rem;">Q55.00</td>
                    <td style=" font-size: 0.7rem;">q20.00</td>


                </tr>
            </tbody>
        </table>

        <div style="flex-direction: column;">
            <div style="flex-direction:row; margin-top: 25px;">
                <span class="campo" style=" font-size: 0.7rem;">Nombre:</span>
                <span class="content" style="width:92%">
                    {{ $dato->first_lastname }} {{ $dato->second_lastname }} {{ $dato->first_name }}
                    {{ $dato->second_name }}
                </span>


            </div>

            <div style="flex-direction:row; margin-top: 5px;">
                <span class="campo" style=" font-size: 0.7rem;">Fecha:</span>
                <span class="content" style="width:93.5%">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>

            </div>
            <div style="flex-direction:row; margin-top: 5px;">

                <span class="campo" style="font-size: 0.7rem;">Metodo de pago: </span>
                <span class="content" style="width:85.5%"> Efectivo </span>
            </div>
            <div style="flex-direction:row; margin-top: 5px;">

                <span class="campo" style=" font-size: 0.7rem;"> Tipo de pago:</span>
                <span class="content" style="width:88%"> Mensualidad </span>
            </div>



            <div style="flex-direction:row; margin-top: 30px;">

                <span class="campo" style=" font-size: 0.7rem;"> Total:</span>
                <span class="" style="width:94.5%"> Q. {{ $dato->personal_code }} </span>
            </div>


        </div>
    @endforeach
    </body>


</html>
