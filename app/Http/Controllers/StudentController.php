<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Log;

use App\Models\Degree;
use App\Models\In_charge;
use App\Models\Sections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StudentController extends Controller
{
    public function listStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $sectionId = request()->query('section_id'); // Nueva variable para la sección
            $search = request()->query('search');

            // Realizar la consulta con filtros de grado, sección y nombre
            $students = Student::with(['studentAssignments.degree', 'studentAssignments.section'])
                ->whereIn('state', [1, 2]) // Filtrar por estado 1 o 2
                ->when($degreeId || $sectionId, function ($query) use ($degreeId, $sectionId) {
                    $query->whereHas('studentAssignments', function ($subQuery) use ($degreeId, $sectionId) {
                        if ($degreeId) {
                            $subQuery->where('degrees_id', $degreeId);
                        }
                        if ($sectionId) {
                            $subQuery->where('section_id', $sectionId);
                        }
                    });
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('first_name', 'LIKE', "%{$search}%");
                })
                ->paginate(10);

            // Obtener grados y secciones para el formulario de selección
            $degrees = Degree::all();
            $sections = Sections::all(); // Asegúrate de que la clase esté correctamente nombrada
            return view('student.listStudent', [
                'student' => $students,
                'degrees' => $degrees,
                'sections' => $sections
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log
            Log::error('Error al listar estudiantes: ' . $e->getMessage(), [
                'degree_id' => $degreeId,
                'section_id' => $sectionId,
                'search' => $search,
                'trace' => $e->getTraceAsString() // Opcional: incluye el stack trace para más información
            ]);

            return redirect('/student')->with('error', 'Ocurrió un problema: ' . $e->getMessage());
        }
    }

    public function showCreateForm()
    {
        $degrees = Degree::all();
        $familiares = Constants::FAMILIARES;
        return view('student.createStudent', ['degrees' => $degrees, 'familiares' => $familiares]);
    }

    public function createStudent(Request $request)
    {
        try {
            // Validación de los datos del estudiante
            $validatedStudent = $request->validate([
                'first_name' => 'required',
                'second_name' => 'nullable',
                'first_lastname' => 'required',
                'second_lastname' => 'nullable',
                'personal_code' => 'required',
                'birthdate' => 'required|date',
                'gender' => 'required',
                'town_ethnicity' => 'nullable'
            ]);

            // Crear el estudiante
            $student = Student::create($validatedStudent);
            $studentId = $student->id;

            // Validación y creación de los encargados
            $request->validate([
                'charge_first_name' => 'required|string|max:255',
                'charge_first_lastname' => 'required|string|max:255',
                'charge_dpi' => 'required|numeric',
                'charge_phone' => 'required|numeric',
                'charge_address' => 'required|string|max:255',
                'charge_first_name_2' => 'nullable|string|max:255',
                'charge_first_lastname_2' => 'nullable|string|max:255',
                'charge_dpi_2' => 'nullable|numeric',
                'charge_phone_2' => 'nullable|numeric',
                'charge_address_2' => 'nullable|string|max:255',
                'charge_first_name_3' => 'nullable|string|max:255',
                'charge_first_lastname_3' => 'nullable|string|max:255',
                'charge_dpi_3' => 'nullable|numeric',
                'charge_phone_3' => 'nullable|numeric',
                'charge_address_3' => 'nullable|string|max:255'
            ]);

            $inCharge1 = In_charge::create([
                'charge_first_name' => $request->charge_first_name,
                'charge_second_name' => $request->charge_second_name ?: null,
                'charge_first_lastname' => $request->charge_first_lastname,
                'charge_second_lastname' => $request->charge_second_lastname ?: null,
                'charge_dpi' => $request->charge_dpi,
                'charge_phone' => $request->charge_phone,
                'charge_address' => $request->charge_address,
                'charge_relationship' => $request->charge_relationship,
                'charge_comment' => $request->charge_comment,
                'charge_first_name_2' => $request->charge_first_name_2,
                'charge_second_name_2' => $request->charge_second_name_2 ?: null,
                'charge_first_lastname_2' => $request->charge_first_lastname_2,
                'charge_second_lastname_2' => $request->charge_second_lastname_2 ?: null,
                'charge_dpi_2' => $request->charge_dpi_2,
                'charge_phone_2' => $request->charge_phone_2,
                'charge_address_2' => $request->charge_address_2,
                'charge_relationship_2' => $request->charge_relationship_2,
                'charge_comment_2' => $request->charge_comment_2,
                'charge_first_name_3' => $request->charge_first_name_3,
                'charge_second_name_3' => $request->charge_second_name_3 ?: null,
                'charge_first_lastname_3' => $request->charge_first_lastname_3,
                'charge_second_lastname_3' => $request->charge_second_lastname_3 ?: null,
                'charge_dpi_3' => $request->charge_dpi_3,
                'charge_phone_3' => $request->charge_phone_3,
                'charge_address_3' => $request->charge_address_3,
                'charge_relationship_3' => $request->charge_relationship_3,
                'charge_comment_3' => $request->charge_comment_3,
                'student_id' => $studentId // Usa el ID del estudiante creado
            ]);

            // Redirigir a la vista de estudiantes con mensaje de éxito
            return redirect('/payments')->with('message', 'Estudiante y encargados creados correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear el estudiante o el encargado' );
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al crear el estudiante o el encargado')
                ->withInput();
        }
    }

    public function disableStudent($id)
    {
        try {
            $student = Student::findOrFail($id);

            $student->disable();

            return redirect('/student')->with('message', 'Estudiante activado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar al estudiante', [
                'student_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/student')->with('error', 'Ocurrió un problema al eliminar al estudiante');
        }
    }

    public function activeStudent($id)
    {
        try {
            $student = Student::findOrFail($id);

            $student->enable();

            return redirect('/student')->with('message', 'Estudiante activado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al habilitar estudiante', [
                'student_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/student')->with('error', 'Ocurrió un problema al habilitar al estudiante');
        }
    }

    public function trashStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $sectionId = request()->query('section_id'); // Nueva variable para la sección
            $search = request()->query('search');

            // Realizar la consulta con filtros de grado, sección y nombre
            $students = Student::with(['studentAssignments.degree', 'studentAssignments.section'])
                ->where('state', 0)
                ->when($degreeId || $sectionId, function ($query) use ($degreeId, $sectionId) {
                    $query->whereHas('studentAssignments', function ($subQuery) use ($degreeId, $sectionId) {
                        if ($degreeId) {
                            $subQuery->where('degrees_id', $degreeId);
                        }
                        if ($sectionId) {
                            $subQuery->where('section_id', $sectionId);
                        }
                    });
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('first_name', 'LIKE', "%{$search}%");
                })
                ->paginate(10);

            // Obtener grados y secciones para el formulario de selección
            $degrees = Degree::all();
            $sections = Sections::all(); // Asegúrate de que la clase esté correctamente nombrada
            return view('student.trashStudent', [
                'student' => $students,
                'degrees' => $degrees,
                'sections' => $sections
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log
            Log::error('Error al listar estudiantes: ' . $e->getMessage(), [
                'degree_id' => $degreeId,
                'section_id' => $sectionId,
                'search' => $search,
                'trace' => $e->getTraceAsString() // Opcional: incluye el stack trace para más información
            ]);

            return redirect('/student/trash')->with('error', 'Ocurrió un problema: ' . $e->getMessage());
        }
    }

    public function formEditStudent($id)
    {
        $studens = Student::with('in_charge')->find($id);
        $familiares = Constants::FAMILIARES;

        return view('student.editStudent', [
            'studens' => $studens,
            'familiares' => $familiares,
            'inCharge' => $studens->inCharge, // Pasa un solo objeto en lugar de una colección
        ]);
    }



    public function editStudent(Request $request, $id)
    {
        try {
            Log::info('Iniciando actualización del estudiante.', ['student_id' => $id]);

            // Buscar el estudiante
            $student = Student::find($id);

            if (!$student) {
                Log::warning('Estudiante no encontrado.', ['student_id' => $id]);
                return redirect('/collaborations')->with('error', 'Colaboración no encontrada.');
            }

            // Verificar si existe un registro de inCharge asociado
            if (!$student->inCharge) {
                Log::warning('No existe un responsable asociado al estudiante.', ['student_id' => $id]);
                return redirect('/student')->with('error', 'No existe un responsable asociado a este estudiante.');
            }

            Log::info('Estudiante y responsable encontrados. Iniciando validación de datos.', ['student_id' => $id]);

            // Validar los datos del estudiante
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'second_name' => 'nullable|string|max:255',
                'first_lastname' => 'nullable|string|max:255',
                'second_lastname' => 'nullable|string|max:255',
                'personal_code' => 'nullable|string|max:255',
                'gender' => 'nullable|string|max:255',
                'birthdate' => 'nullable|string|max:255',
                'town_ethnicity' => 'nullable|string|max:255',
            ]);

            Log::info('Datos del estudiante validados correctamente.', ['student_id' => $id]);

            // Validar los datos del responsable
            $validatedInChargeData = $request->validate([
                'charge_first_name' => 'nullable|string|max:255',
                'charge_second_name' => 'nullable|string|max:255',
                'charge_first_lastname' => 'nullable|string|max:255',
                'charge_second_lastname' => 'nullable|string|max:255',
                'charge_dpi' => 'nullable|string|max:255',
                'charge_phone' => 'nullable|string|max:255',
                'charge_address' => 'nullable|string|max:255',
                'charge_relationship' => 'nullable|string|max:255',
                'charge_comment' => 'nullable|string|max:255',
                'charge_first_name_2' => 'nullable|string|max:255',
                'charge_second_name_2' => 'nullable|string|max:255',
                'charge_first_lastname_2' => 'nullable|string|max:255',
                'charge_second_lastname_2' => 'nullable|string|max:255',
                'charge_dpi_2' => 'nullable|string|max:255',
                'charge_phone_2' => 'nullable|string|max:255',
                'charge_address_2' => 'nullable|string|max:255',
                'charge_relationship_2' => 'nullable|string|max:255',
                'charge_comment_2' => 'nullable|string|max:255',
                'charge_first_name_3' => 'nullable|string|max:255',
                'charge_second_name_3' => 'nullable|string|max:255',
                'charge_first_lastname_3' => 'nullable|string|max:255',
                'charge_second_lastname_3' => 'nullable|string|max:255',
                'charge_dpi_3' => 'nullable|string|max:255',
                'charge_phone_3' => 'nullable|string|max:255',
                'charge_address_3' => 'nullable|string|max:255',
                'charge_relationship_3' => 'nullable|string|max:255',
                'charge_comment_3' => 'nullable|string|max:255',
            ]);

            Log::info('Datos del responsable validados correctamente.', ['student_id' => $id]);

            // Actualizar los datos del estudiante
            $student->update($validatedData);
            Log::info('Datos del estudiante actualizados correctamente.', ['student_id' => $id]);

            // Actualizar los datos del responsable (In_Charge)
            $student->inCharge->update($validatedInChargeData);
            Log::info('Datos del responsable actualizados correctamente.', ['student_id' => $id]);

            return redirect('/student')->with('message', 'Estudiante actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el usuario.', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el usuario');
        }
    }


    // TODO: mover esta funcion al controlador correspondiente y corregir la ruta
    public function paymentTicket()
    {
        $uuid = (string) Str::uuid();
        $date = Carbon::now();
        $name = 'Jaime Rax';

        $data['uuid'] = $uuid;
        $data['date'] = $date;
        $data['name'] = $name;

        // Cargar la vista con los datos y generar el PDF
        $pdf = PDF::loadView('Reports.Payment.paymentTicket', $data)->setPaper('letter', 'portrait')->stream('ticket_payment.pdf');

        return $pdf;
    }
}
