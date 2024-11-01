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

    public function pdfReportMonth()
    {
        // Llamada al procedimiento almacenado
        $results = DB::select('CALL corteCajaMensual()');
        // Obtén el username del usuario autenticado
        $username = Auth::user()->username;
        $uuid = Str::uuid();

        // Cargar la vista y pasar los datos a la misma, incluyendo el username
        $pdf = Pdf::loadView('pdf.reportPaymentMonth', [
            'payments' => $results,
            'username' => $username,
            'uuid' => $uuid
        ]);

        // Descargar el PDF con un nombre específico
        return $pdf->download('Recorte_caja_mensual.pdf');
    }

    public function pdfReportDiary()
    {
        // Llamada al procedimiento almacenado
        $results = DB::select('CALL corteCajaDiario()');

        $username = Auth::user()->username;
        $uuid = Str::uuid();

        // Generar el PDF usando la vista y los datos obtenidos
        $pdf = Pdf::loadView('pdf.reportPaymentDiary', [
            'payments' => $results,
            'username' => $username,
            'uuid' => $uuid
        ]);

        // Descargar o visualizar el PDF
        return $pdf->download('Reporte_Corte_Caja_Diario.pdf');
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
