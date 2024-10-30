<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Sections;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\GeneralAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function listRatings()
    {
        try {
            $user = Auth::user();

            $degreeId = request()->query('degree_id');
            $sectionId = request()->query('section_id');
            $courseId = request()->query('course_id'); // Agregado para filtrar por curso
            $search = request()->query('search');

            if ($user && $user->hasRole('docente')) {
                // Obtener las asignaciones generales del docente
                $generalAssignments = GeneralAssignment::where('teachers_id', $user->id)
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degrees_id', $degreeId);
                    })
                    ->when($sectionId, function ($query) use ($sectionId) {
                        return $query->where('section_id', $sectionId);
                    })
                    ->when($courseId, function ($query) use ($courseId) {
                        return $query->where('course_id', $courseId);
                    })
                    ->pluck('id');

                // Consulta de estudiantes
                $students = Student::whereIn('state', [1, 2])
                    ->whereHas('studentAssignments', function ($query) use ($generalAssignments) {
                        return $query->whereIn('general_assignment_id', $generalAssignments);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10)
                    ->appends([
                        'degree_id' => $degreeId,
                        'section_id' => $sectionId,
                        'course_id' => $courseId, // Agregado para mantener el valor de curso
                        'search' => $search
                    ]);

                // Obtener grados, secciones y cursos
                $degrees = Degree::all();
                $sections = Sections::all();
                $courses = Courses::all(); // Asegúrate de que tengas este modelo

                // Obtener actividades relacionadas con las asignaciones generales
                $activities = Activity::whereIn('general_assignment_id', $generalAssignments)->get();

                // Retornar la vista con los estudiantes, actividades y los selectores
                return view('ratings.listRatings', [
                    'students' => $students,
                    'activities' => $activities, // Pasar actividades a la vista
                    'degrees' => $degrees,
                    'sections' => $sections,
                    'courses' => $courses // Pasar cursos a la vista
                ]);
            }

            return redirect('/ratings');
        } catch (\Exception $e) {
            return redirect('/ratings')->with('error', 'Ocurrió un problema al listar las calificaciones.');
        }
    }


    //     public function editRatings($id){
    //         try {
    //             $ratings = Collaborations::find($id);

    //             if (!$ratings) {
    //                 return redirect('/collaborations')->with('error', 'Colaboración no encontrada.');
    //             }

    //             $validatedData = $request->validate([
    //                 'name' => 'required|string|max:255'
    //             ]);

    //             $ratings->update($validatedData);

    //             return redirect('/ratings')->with('message', 'Colaboración actualizada correctamente.');
    //         } catch (\Exception $e) {
    //             return redirect('/ratings')->with('error', 'Ocurrió un problema al actualizar la colaboración');
    //         }
    //  }

    public function generatePDF(Request $request)
    {
        // Estructuramos los datos de los estudiantes
        $studentIds = $request->input('student_ids'); // Array con los IDs de los estudiantes
        $actividad1 = $request->input('actividad1'); // Array con notas de actividad1
        $actividad2 = $request->input('actividad2'); // Repite para otros campos como actividad3, mejoramiento1, etc.
        $actividad3 = $request->input('actividad3');
        $mejoramiento1 = $request->input('mejoramiento1');
        $mejoramiento2 = $request->input('mejoramiento2');
        $mejoramiento3 = $request->input('mejoramiento3');
        $disciplina = $request->input('Disciplina');
        $extracurricular = $request->input('extracurricular');
        $examen = $request->input('examen');
        $notaFinal = $request->input('notaFinal');

        // Creamos un array estructurado para cada estudiante
        $studentIds = $request->input('student_ids'); // Array con los IDs de los estudiantes

    // Obtener nombres de estudiantes de la base de datos
    $students = DB::table('tb_student')
        ->whereIn('id', $studentIds)
        ->get(['id', 'first_name', 'second_name', 'first_lastname', 'second_lastname']);

    // Crear un arreglo estructurado para cada estudiante
    $studentsData = [];
        foreach ($students as $index => $student) {
            $studentsData[] = [
                'id' => $student->id,
                'nombre' => trim("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}"),
                'actividad1' => $actividad1[$index] ?? 0,
                'actividad2' => $actividad2[$index] ?? 0,
                'actividad3' => $actividad3[$index] ?? 0,
                'mejoramiento1' => $mejoramiento1[$index] ?? 0,
                'mejoramiento2' => $mejoramiento2[$index] ?? 0,
                'mejoramiento3' => $mejoramiento3[$index] ?? 0,
                'disciplina' => $disciplina[$index] ?? 0,
                'extracurricular' => $extracurricular[$index] ?? 0,
                'examen' => $examen[$index] ?? 0,
                'notaFinal' => $notaFinal[$index] ?? 0,
            ];
        }

        // Generamos el PDF pasando los datos estructurados
        $pdf = PDF::loadView('pdf.notas', compact('studentsData'));

        // Descargamos el PDF
        return $pdf->download('Reporte_Estudiantes.pdf');
    }

}
