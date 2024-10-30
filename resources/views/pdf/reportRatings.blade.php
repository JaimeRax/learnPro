<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Calificaciones</title>
    <style>
        /* Puedes agregar estilos para el PDF aquí */
    </style>
</head>
<body>
    <h1>Reporte de Calificaciones</h1>

    @foreach ($students as $student)
        <h2>{{ strtoupper($student->full_name) }}</h2> <!-- Suponiendo que tienes un método full_name en tu modelo -->
        <table>
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->ratings as $rating)
                    <tr>
                        <td>{{ $rating->activity->name }}</td> <!-- Asegúrate de que el nombre de la relación sea correcto -->
                        <td>{{ $rating->score_obtained }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
