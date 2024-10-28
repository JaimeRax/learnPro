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
            $sectionId = request()->query('section_id');
            $search = request()->query('search');

            $students = Student::whereIn('state', [1, 2])
                ->when($degreeId || $sectionId, function ($query) use ($degreeId, $sectionId) {
                    $query->whereHas('assignments', function ($query) use ($degreeId, $sectionId) {
                        $query->when($degreeId, function ($query) use ($degreeId) {
                            return $query->where('degrees_id', $degreeId);
                        })
                        ->when($sectionId, function ($query) use ($sectionId) {
                            return $query->where('section_id', $sectionId);
                        });
                    });
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('first_name', 'LIKE', "%{$search}%");
                })
                ->paginate(10)
                ->appends([
                    'degree_id' => $degreeId,
                    'section_id' => $sectionId,
                    'search' => $search
                ]);

            $degrees = Degree::all();
            $sections = Sections::all();

            return view('student.listStudent', [
                'student' => $students,
                'degrees' => $degrees,
                'sections' => $sections,
            ]);

        } catch (\Exception $e) {
            return redirect('/student')->with('error', 'Ocurrió un problema.');
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
                'town_ethnicity' => 'nullable',
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
            return redirect('/payments')->with('success', 'Estudiante y encargados creados correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear el estudiante o el encargado: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al crear el estudiante o el encargado: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function disableStudent($id)
    {
        $student = Student::find($id);
        $student->disable();
        return redirect('/student');
    }

    public function activeStudent($id)
    {
        $student = Student::find($id);
        $student->enable();
        return redirect('/student');
    }

    public function trashStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $student = Student::where('state', 0)
                ->when($degreeId, function ($query) use ($degreeId) {
                    return $query->where('degree_id', $degreeId);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('name', 'LIKE', "%{$search}%");
                })
                ->paginate(10)
                ->appends([
                    'degree_id' => $degreeId,
                    'search' => $search
                ]);


            } else {
                $student = Student::where('state', 0)->paginate(10);
            }

            $degrees = Degree::all();

            return view('student.trashStudent', [
               'student' => $student,
                'degrees' => $degrees,
            ]);

        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Ocurrió un problema.');
        }

    }

    public function editStudent(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect('/student')->with('error', 'Estudiante no encontrado.');
        }

        $student->update($request->validated());

        return redirect('/student')->with('success', 'Estudiante actualizado correctamente.');
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
        $pdf = PDF::loadView('Reports.Payment.paymentTicket', $data)
            ->setPaper('letter', 'portrait')
            ->stream('ticket_payment.pdf');

        return $pdf;
    }


}
