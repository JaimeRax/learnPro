<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\MonthlyPayment;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use App\Models\Degree;
use App\Models\Payments;
use App\Models\User;
use App\Models\Sections;
use Faker\Provider\ar_EG\Payment;
use NumberFormatter;
use Illuminate\Support\Facades\DB;

class paymentsController extends Controller
{
    public function listPayments()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $student = Student::whereIn('state', [1, 2])
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degree_id', $degreeId);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%");
                    })
                    ->with(['degree', 'section'])
                    ->paginate(10)
                    ->appends([
                        'degree_id' => $degreeId,
                        'search' => $search
                    ]);
            } else {
                $student = Student::whereIn('state', [1, 2])
                    ->with(['degree', 'section'])
                    ->paginate(10);
            }

            $degrees = Degree::all();
            $sections = Sections::all();
            $users = User::all();

            return view('payments.listPayments', [
                'student' => $student,
                'degrees' => $degrees,
                'sections' => $sections,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return redirect('/payments')->with('error', 'Ocurrió un problema.');
        }
    }

    public function ShowcreatePayments(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();

        return view('payments.newPayment', [
            'student' => $student,
            'degrees' => $degrees,
            'sections' => $sections,
            'users' => $users
        ]);
    }

    public function createPayments(Request $request, $id)
    {
        dd($request->toArray());
        try {
            // Validación de los datos del estudiante
            $validatedData = $request->validate([
                'payment_date' => 'required|date',
                'type_payment' => 'required',
                'mood_payment' => 'required|string',
                'uuid' => 'required|string',
                'month' => 'string',
                'amount' => 'required|integer',
                'bank' => 'nullable|string',
                'document_number' => 'required|integer',
                'comment' => 'nullable|string',
                'student_id' => 'required|integer',
                'user_id' => 'required|integer'
            ]);

            // Crear el pago
            $payment = Payments::create($validatedData);

            $student = Student::findOrFail($validatedData['student_id']);
            $student->state = 1;
            $student->save();

            $users = User::all();

            // Generar los datos para el PDF
            $data = [
                'title' => 'Welcome to Payments',
                'date' => date('m/d/y'),
                'payments' => collect([$student]),
                'users' => $users,
                'pay' => collect([$payment])
            ];

            // Generar el PDF
            $pdf = PDF::loadview('pdf.myPDF', $data);
            return $pdf->download('pagos.pdf');
        } catch (\Exception $e) {
            Log::error('Error al crear el pago o actualizar el estudiante: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al crear el pago o actualizar el estudiante: ' . $e->getMessage())
                ->withInput();
        }
    }

}
