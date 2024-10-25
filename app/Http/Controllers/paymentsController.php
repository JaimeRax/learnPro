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

            $collaborations = Collaborations::where('state', 1)->get();

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
        $collaborations = Collaborations::where('state', 1)->get();

        $student = Student::with(['payments' => function ($query) {
            $query->where('year', date('Y'));
        }])->findOrFail($id);
        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();

        return view('payments.newPayment', [
            'student' => $student,
            'degrees' => $degrees,
            'sections' => $sections,
            'users' => $users,
            'collaborations' => $collaborations
        ]);
    }


    public function createPayments(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'type_payment' => 'required|string',
                'name_collaboration' => 'nullable|string',
                'mood_payment' => 'required|string',
                'payment_date' => 'required|date',
                'amount' => 'required|integer',
                'bank' => 'nullable|string',
                'month' => 'nullable|array',
                'document_number' => 'nullable|integer',
                'comment' => 'nullable|string',
                'student_id' => 'required|integer'
            ]);

            $today = Carbon::now();
            $currentYear = $today->year;

            $validatedData['payment_date'] = Carbon::parse($validatedData['payment_date'])->format('Y-m-d');

            $paymentsCollection = collect();

            // Verificar si month está presente en la solicitud
            if (isset($validatedData['month']) && !empty($validatedData['month'])) {
                foreach ($validatedData['month'] as $month) {
                    Log::error('mes: ' . $month);
                    $uuid = Str::uuid();
                    $payment = Payments::create([
                        'payment_date' => $validatedData['payment_date'],
                        'type_payment' => $validatedData['type_payment'],
                        'name_collaboration' => $validatedData['name_collaboration'],
                        'mood_payment' => $validatedData['mood_payment'],
                        'uuid' => $uuid,
                        'paid_month' => $month,
                        'year' => $currentYear,
                        'amount' => $validatedData['amount'],
                        'bank' => $validatedData['bank'],
                        'document_number' => $validatedData['document_number'],
                        'comment' => $validatedData['comment'],
                        'student_id' => $validatedData['student_id'],
                        'user_id' => $request->user()->id,
                    ]);

                    $paymentsCollection->push($payment);
                }
            } else {
                // Crear un registro de pago único si no hay meses pagados
                $uuid = Str::uuid();
                $payment = Payments::create([
                    'payment_date' => $validatedData['payment_date'],
                    'type_payment' => $validatedData['type_payment'],
                    'name_collaboration' => $validatedData['name_collaboration'],
                    'mood_payment' => $validatedData['mood_payment'],
                    'uuid' => $uuid,
                    'paid_month' => null,
                    'year' => $currentYear,
                    'amount' => $validatedData['amount'],
                    'bank' => $validatedData['bank'],
                    'document_number' => $validatedData['document_number'],
                    'comment' => $validatedData['comment'],
                    'student_id' => $validatedData['student_id'],
                    'user_id' => $request->user()->id,
                ]);

                $paymentsCollection->push($payment);
            }

            $student = Student::findOrFail($validatedData['student_id']);
            $student->state = $validatedData['type_payment'] === 'inscripcion' ? 0 : 1;
            $student->save();

            $users = User::all();

            // Generar los datos para el PDF
            $data = [
                'payments' => $paymentsCollection,
                'student' => $student,
                'users' => $users
            ];

            // Generar el PDF
            // $pdf = PDF::loadview('pdf.myPDF', $data);

            if($student->state == 1) {
                return redirect('/payments')->with('message', 'El pago se registró con éxito.');
            } else {
                return redirect('/assignment/student')->with('message', 'El pago se registró con éxito.')->with('swal', true);
            }

        } catch (\Exception $e) {
            Log::error('Error al crear el pago o actualizar el estudiante: ' . $e->getMessage());
            return redirect('/payments')->with('error', 'Ocurrió un problema al crear el pago. ');
        }
    }
}
