<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Voucher Pago')</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:wght@100&display=swap');

            .roboto-thin {
                font-family: "Roboto", sans-serif;
                font-weight: 100;
                font-style: normal;
            }

            .header {
                line-height: 0.3;
                padding-bottom: 5px;
                border-bottom: 1px solid #ddd;
            }

            .contact-info {
                float: right;
                text-align: right;
                line-height: 0.5;
                margin: 0;
                padding: 0;
            }

            .logo {
                width: 90px;
                display: inline-block;
                vertical-align: middle;
                margin-top: -15px;
            }

            .text-container {
                display: inline-block;
                vertical-align: middle;
                font-size: 0.6rem; /* Reducido el tamaño de la fuente */
                line-height: 1; /* Ajustado para mayor claridad */
                margin: 0;
                line-height: 0.1;
                padding: 0;
            }

            .text-container .title {
                display: inline-block;
                vertical-align: middle;
                font-size: 0.7rem; /* Tamaño reducido para títulos */
                line-height: 1;
                margin: 0;
                padding: 0;
            }

            /* Estilos del contenido */
            .content {
                font-size: 1.3rem;
                margin-top: 3px;
            }

            /* Estilos del pie de página */
            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                text-align: center;
                font-size: 0.6rem;
                color: #333333;
                border-top: 1px solid #ddd;
                display: flex;
                justify-content: space-between;
                padding: 20px;
            }

            .footer .infor {
                text-align: left;
            }

            .footer .uuid {
                text-align: right;
            }

            .footer .infor p,
            .footer .uuid p {
                margin: 0;
            }
        </style>
    </head>
    <body>

        <!-- Encabezado -->
        <div class="header">
            <div class="contact-info">
                <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />
            </div>
            <div class="text-container">
                <p class="roboto-thin">INSTITUTO DE EDUCACION BASICA</p>
                <p class="roboto-thin">POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
                <p class="roboto-thin" style="font-size: 12px;">Autorizado por Acuerdo Ministerial
                    No. 475
                </p>
                <p class="roboto-thin">4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché</p>
                <p class="roboto-thin">San Juan Chamelco Alta Verapaz</p>
                <p class="roboto-thin">institutobasicojv.chamelco@gmail.com</p>
                <p class="roboto-thin">Tel. (+502) 5991 0548</p>
            </div>
        </div>

        <!-- Contenido de la vista -->
        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <div>
                <p class="roboto-thin" style="word-spacing: 50px;">{{ $username }}  {{ $uuid }}
                    {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
            </div>
            <div style="clear: both;"></div>
        </div>


    </body>
</html>
