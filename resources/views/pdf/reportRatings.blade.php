<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Notas de Estudiantes</title>
    <style>
        @page {
            margin-top: 1cm;
            margin-left: 1.8cm;
            margin-bottom: 1cm;
            margin-right: 1.8cm;
            line-height: 1.5;
            font-size: 12px;
            text-align: justify;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            color: #2c3532;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            background: #1bb1e2;
            color: #FFFFFF;
            height: 24px;
            border-radius: 3px;
            padding: 5px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            font-size: 10px;
            color: #000000;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            font-size: 10px;
            color: #000000;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            background-color: #FFFFFF;
            color: #2d352c;
            text-align: center;
            border-collapse: collapse;
            border: 1px solid #2c2e35;
            border-radius: 11px;
        }

        th {
            background: #29a4ce;
            color: white;
            padding: 8px;
            font-size: 10px;
        }

        td {
            padding: 8px;
            font-size: 10px;
            border-top: 0.5px solid #2c2e35;
            text-transform: capitalize;
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
    <div class="header">
        <div class="contact-info lato-regular">
            <p>4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché San Juan Chamelco Alta Verapaz</p>
            <p>institutobasicojv.chamelco@gmail.com</p>
            <p>Tel. (+502) 5991 0548</p>
        </div>
        <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />
        <div class="text-container" >
            <p class="lato-bold">INSTITUTO DE EDUCACION BASICA</p>
            <p class="lato-bold">POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
            <p class="lato-regular-italic">Autorizado por Acuerdo Ministerial NO. 475</p>
        </div>
    </div>

    <h1>Reporte de Notas de Estudiantes</h1>
    <h2>PRIMERO A MATEMATICA</h2>
    <h3>DOCENTE: VICTOR TUN</h3>
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
                    <td>{{ $student->first_name }} {{ $student->last_name }} {{ $student->first_lastname }} {{ $student->second_lastname }} </td>
                    @php $totalScore = 0; @endphp <!-- Inicializar totalScore -->
                    @foreach ($activities as $activity)
                        @php
                            $score = $ratings[$student->id][$activity->id]->score_obtained ?? 0; // Obtener calificación
                            $totalScore += $score; // Sumar calificación al total
                        @endphp
                        <td>
                            {{ $score }}
                        </td>
                    @endforeach
                    <td>{{ $totalScore }}</td> <!-- Mostrar la suma total -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
