@extends('components.template.payments')

@section('title', 'Estado General de Estudiantes Mensual')

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
    @include('styles.partials.title', ['title' => 'Estado General de Estudiantes Mensual'])
    <h1> Fecha del "{{ $start_date }}" al "{{ $end_date }}"</h1>
    <div style="padding: 10px; background-color: #fff; border-radius: 8px; margin: 10px 0;">

        <table class="table">
            <thead>
                <tr>
                    <th class="nameColumn">No</th>
                    <th class="nameColumn">Nombre Estudiante</th>
                    <th class="nameColumn">Estado</th>
                    <th class="nameColumn">Ultima Fecha de Pago</th>
                    <th class="nameColumn">Montos Pagados</th>
                    <th class="nameColumn">Fechas de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->status }}</td>
                        <td>{{ $student->last_payment_date ? \Carbon\Carbon::parse($student->last_payment_date)->format('d-m-Y') : 'N/A' }}</td>
                        <td>{{ $student->all_payments }}</td>
                        <td>{{ $student->payment_dates }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
