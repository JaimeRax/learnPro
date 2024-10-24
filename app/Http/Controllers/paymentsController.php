<?php

namespace App\Http\Controllers;

use App\Models\Collaborations;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Degree;
use App\Models\Payments;
use App\Models\User;
use App\Models\Sections;
use Carbon\Carbon;
use Illuminate\Support\Str;

class paymentsController extends Controller
{
    public function listPayments()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            // if ($degreeId || $search) {
            //     $student = Student::whereIn('state', [0,1, 2])
            //         ->when($degreeId, function ($query) use ($degreeId) {
            //             return $query->where('degree_id', $degreeId);
            //         })
            //         ->when($search, function ($query) use ($search) {
            //             return $query->where('first_name', 'LIKE', "%{$search}%");
            //         })
            //         ->with(['degree', 'section', 'payments' => function ($query) {
            //             $query->where('year', date('Y'));
            //         }])
            //         ->paginate(10)
            //         ->appends([
            //             'degree_id' => $degreeId,
            //             'search' => $search
            //         ]);
            // } else {
            $student = Student::whereIn('state', [0, 1])
                // ->with(['degree', 'section', 'payments' => function ($query) {
                //     $query->where('year', date('Y'));
                // }])
                ->paginate(10);
            // }

            $collaborations = Collaborations::all();
            $degrees = Degree::all();
            $sections = Sections::all();
            $users = User::all();

            // dd($student->toArray());
            $months = Constants::MONTHS;

            return view('payments.listPayments', [
                'student' => $student,
                'degrees' => $degrees,
                'sections' => $sections,
                'users' => $users,
                'months' => $months,
                'collaborations' => $collaborations,

            ]);
        } catch (\Exception $e) {
            return redirect('/payments')->with('error', 'Ocurrió un problema.');
        }
    }

    public function ShowcreatePayments(Request $request, $id)
    {
        $collaborations = Collaborations::all();
        $student = Student::findOrFail($id);
        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();

        return view('payments.newPayment', [
            'student' => $student,
            'degrees' => $degrees,
            'sections' => $sections,
            'users' => $users,
            'collaborations'=> $collaborations
        ]);
    }

    public function createPayments(Request $request, $id)
    {
        try {
            // Validación de los datos del estudiante
            $validatedData = $request->validate([
                'type_payment' => 'required',
                'name_collaboration' => 'nullable',
                'mood_payment' => 'required|string',
                'payment_date' => 'required|date',
                'amount' => 'required|integer',
                'bank' => 'nullable|string',
                'months' => 'nullable|array',
                'document_number' => 'nullable|integer',
                'comment' => 'nullable|string',
                'student_id' => 'required|integer'
            ]);

            $today = Carbon::now();
            $currentYear = $today->year;

            if (empty($validatedData['months'])) {
                $validatedData['month'] = [0]; // Asigna un array con 0
            }

            $validatedData['payment_date'] = Carbon::parse($validatedData['payment_date'])->format('Y-m-d');

            $paymentsCollection = collect();

            // dd($validatedData);

            foreach ($validatedData['months'] as $month) {
                $uuid = Str::uuid();
                $payment = Payments::create([
                    'payment_date' => $validatedData['payment_date'],
                    'type_payment' => $validatedData['type_payment'],
                    'name_collaboration' => $validatedData['name_collaboration'],
                    'mood_payment' => $validatedData['mood_payment'],
                    'uuid' => $uuid,
                    'month' => $month,
                    'year' => $currentYear,
                    'amount' => $validatedData['amount'],
                    'bank' => $validatedData['bank'],
                    'document_number' => $validatedData['document_number'],
                    'comment' => $validatedData['comment'],
                    'student_id' => $validatedData['student_id'],
                    'user_id' => $request->user()->id
                ]);

                $paymentsCollection->push($payment);
            }

            $student = Student::findOrFail($validatedData['student_id']);
            $student->state = 1;
            $student->save();

            $users = User::all();

            // Generar los datos para el PDF
            $data = [
                'payments' => $paymentsCollection,
                'student' => $student,
                'users' => $users
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
