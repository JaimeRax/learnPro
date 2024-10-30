<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Degree;
use App\Models\Sections;
use Illuminate\Http\Request;

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
}
