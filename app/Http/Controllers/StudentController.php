<?php

namespace App\Http\Controllers;

use App\Http\Requests\InChargeRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Degree;
use App\Models\In_charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StudentController extends Controller
{
    public function listStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $student = Student::whereIn('state', [1,2])
                ->when($degreeId, function($query) use ($degreeId) {
                    return $query->where('degree_id', $degreeId);
                })
                ->when($search, function($query) use ($search) {
                    return $query->where('first_name', 'LIKE', "%{$search}%");
                })
                ->paginate(2)
                ->appends([
                    'degree_id' => $degreeId,
                    'search' => $search
                ]);


            } else {
                $student = Student::whereIn('state', [1,2])->paginate(2);
            }

            $degrees = Degree::all();

            return view('student.listStudent', [
               'student' => $student,
                'degrees' => $degrees,
            ]);

        } catch (\Exception $e) {
            return redirect('/student')->with('error', 'Ocurrió un problema.');
        }


    }

    public function showCreateForm()
    {
        $degrees = Degree::all();
        return view('student.createStudent',[   'degrees' => $degrees,]);
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

            // Usar el ID del estudiante recién creado
            $studentId = $student->id;

            // Validación y creación de los encargados
            $request->validate([
                'charge_first_name' => 'required|string|max:255',
                'charge_first_lastname' => 'required|string|max:255',
                'charge_dpi' => 'required|string|min:13|max:13',
                'charge_phone' => 'required|integer',
                'charge_address' => 'required|string|max:255'
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
                'student_id' => $studentId // Usa el ID del estudiante creado
            ]);

            // Validación y creación del segundo encargado
            $request->validate([
                'charge_first_name_2' => 'nullable|string|max:255',
                'charge_first_lastname_2' => 'nullable|string|max:255',
                'charge_dpi_2' => 'nullable|string|min:13|max:13',
                'charge_phone_2' => 'nullable|integer',
                'charge_address_2' => 'nullable|string|max:255'
            ]);

            $inCharge2 = In_charge::create([
                'charge_first_name' => $request->charge_first_name_2,
                'charge_second_name' => $request->charge_second_name_2 ?: null,
                'charge_first_lastname' => $request->charge_first_lastname_2,
                'charge_second_lastname' => $request->charge_second_lastname_2 ?: null,
                'charge_dpi' => $request->charge_dpi_2,
                'charge_phone' => $request->charge_phone_2,
                'charge_address' => $request->charge_address_2,
                'charge_relationship' => $request->charge_relationship_2,
                'charge_comment' => $request->charge_comment_2,
                'student_id' => $studentId // Usa el ID del estudiante creado
            ]);

            if ($request->has('charge_first_name_3') && !empty($request->charge_first_name_3)) {
                $request->validate([
                    'charge_first_name_3' => 'nullable|string|max:255',
                    'charge_first_lastname_3' => 'nullable|string|max:255',
                    'charge_dpi_3' => 'nullable|string|min:13|max:13',
                    'charge_phone_3' => 'nullable|integer',
                    'charge_address_3' => 'nullable|string|max:255'
                ]);

                $inCharge3 = In_charge::create([
                    'charge_first_name' => $request->charge_first_name_3,
                    'charge_second_name' => $request->charge_second_name_3 ?: null,
                    'charge_first_lastname' => $request->charge_first_lastname_3,
                    'charge_second_lastname' => $request->charge_second_lastname_3 ?: null,
                    'charge_dpi' => $request->charge_dpi_3,
                    'charge_phone' => $request->charge_phone_3,
                    'charge_address' => $request->charge_address_3,
                    'charge_relationship' => $request->charge_relationship_3,
                    'charge_comment' => $request->charge_comment_3,
                    'student_id' => $studentId
                ]);
            }

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
                ->when($degreeId, function($query) use ($degreeId) {
                    return $query->where('degree_id', $degreeId);
                })
                ->when($search, function($query) use ($search) {
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
}
