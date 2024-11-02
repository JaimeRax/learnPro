<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Degree;
use App\Models\Student;
use App\Models\Payments;
use App\Models\Sections;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Collaborations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function ShowcreatePayments($id)
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
                        'amount' => 75,
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

            $users = Auth::user()->username; // Obtiene solo el campo username

            // Generar los datos para el PDF
            $data = [
                'payments' => $paymentsCollection,
                'student' => $student,
                'username' => $users, // Cambia 'users' a 'username'
                'uuid' => $uuid,
            ];

            // Generar el PDF
            $pdf = PDF::loadView('pdf.myPDF', $data);
            $pdfPath = storage_path("app/public/comprobantes/comprobante_pago_{$uuid}.pdf");
            $pdf->save($pdfPath);

            // Guardar la ruta y el estado del botón de asignación en la sesión
            session()->flash('pdf_url', asset("storage/comprobantes/comprobante_pago_{$uuid}.pdf"));
            session()->flash('show_assignment_button', $validatedData['type_payment'] === 'inscripcion');
            session()->flash('payment_created', true); // Indica que el pago fue creado

            return redirect('/payments')->with('message', 'El pago se registró con éxito.');

        } catch (\Exception $e) {
            Log::error('Error al crear el pago o actualizar el estudiante: ' . $e->getMessage());
            return redirect('/payments')->with('error', 'Ocurrió un problema al crear el pago. ' . $e->getMessage());
        }
    }

    public function listPaymentStudent($id)
    {
        $payments = Payments::where('student_id', $id)->get();

        return view('payments.paymentStudent', [
                'payments' => $payments,
        ]);
    }

    public function destroy($id)
    {
        $payment = Payments::find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        try {
            $payment->delete();
            return redirect('/payments/')->with('message', 'Pago eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect('/payments')->with('error', 'Ocurrió un error al eliminar el pago: ');
        }
    }

}
