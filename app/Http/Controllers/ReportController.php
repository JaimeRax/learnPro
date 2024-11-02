<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Courses;
use App\Models\Sections;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function showGeneratePDFForm()
    {
        // Obtén los grados, secciones y cursos necesarios para la vista
        $degree = Degree::all(); // Ajusta esto según tus necesidades
        $section = Sections::all();
        $course = Courses::all();

        // Retorna la vista con los datos
        return view('Reports.reportRatings', compact('degree', 'section', 'course'));
    }

    public function showReportPayments()
    {
        // Obtén los grados, secciones y cursos necesarios para la vista
        $degree = Degree::all(); // Ajusta esto según tus necesidades
        $section = Sections::all();
        $course = Courses::all();

        // Retorna la vista con los datos
        return view('Reports.Payment.paymentsMonth');
    }

    public function pdfReportMonth(Request $request)
    {
        // Validar las fechas de entrada
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Llamar al procedimiento almacenado con las fechas
        $resultados = DB::select('CALL corte_caja_mensual(?, ?)', [
            $request->input('fecha_inicio'),
            $request->input('fecha_fin'),
        ]);

        $username = Auth::user()->username;
        $uuid = Str::uuid();

        // Inicializar un arreglo para almacenar los totales por grado
        $totalesPorGrado = [];

        foreach ($resultados as $result) {
            // Extraer el nombre del grado
            $grado = $result->degree_name;

            // Si el grado no existe en el arreglo, inicializarlo
            if (!isset($totalesPorGrado[$grado])) {
                $totalesPorGrado[$grado] = [
                    'total_records' => 0,
                    'total_amount' => 0.0,
                ];
            }

            // Sumar los registros y los montos al grado correspondiente
            $totalesPorGrado[$grado]['total_records'] += $result->total_records;
            $totalesPorGrado[$grado]['total_amount'] += $result->total_amount;
        }
        // Generar el PDF con los resultados y totales
        $pdf = Pdf::loadView('pdf.reportPaymentMonth', [
            'resultados' => $resultados,
            'totalesPorGrado' => $totalesPorGrado,
            'username' => $username,
            'uuid' => $uuid,
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'fecha_inicio' => $request->input('fecha_inicio'), // Pasar la fecha de inicio
            'fecha_fin' => $request->input('fecha_fin'),
        ]);

        return $pdf->download('Recorte_caja_mensual.pdf');
    }


    public function pdfReportDiary()
    {
        $resultados = DB::select('CALL corte_caja_diario()');
        $username = Auth::user()->username;
        $uuid = Str::uuid();

        // Inicializar un arreglo para almacenar los totales por grado
        $totalesPorGrado = [];

        foreach ($resultados as $result) {
            // Extraer el nombre del grado
            $grado = $result->degree_name;

            // Si el grado no existe en el arreglo, inicializarlo
            if (!isset($totalesPorGrado[$grado])) {
                $totalesPorGrado[$grado] = [
                    'total_records' => 0,
                    'total_amount' => 0.0,
                ];
            }

            // Sumar los registros y los montos al grado correspondiente
            $totalesPorGrado[$grado]['total_records'] += $result->total_records;
            $totalesPorGrado[$grado]['total_amount'] += $result->total_amount;
        }

        // Puedes convertir el arreglo a un formato que te convenga o pasarlo a la vista
        $pdf = Pdf::loadView('pdf.reportPaymentDiary', [
            'resultados' => $resultados,
            'totalesPorGrado' => $totalesPorGrado, // Pasar el total por grado
            'username' => $username,
            'uuid' => $uuid,
        ]);

        return $pdf->download('Recorte_caja_diario.pdf');
    }


    public function pdfReportStatusMonth(Request $request)
    {
        // Validar las fechas de inicio y fin
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $username = Auth::user()->username;
        $uuid = Str::uuid();
        // Llamar al procedimiento almacenado
        $results = DB::select('CALL estadoGegneralmensual(?, ?)', [$validatedData['start_date'], $validatedData['end_date']]);

        // Crear un PDF usando DomPDF
        $pdf = PDF::loadView('pdf.StatusMonth', ['students' => $results, 'username' => $username,
        'uuid' => $uuid, ]);

        // Retornar el PDF al navegador
        return $pdf->download('estado_general_estudiantes.pdf');
    }

}
