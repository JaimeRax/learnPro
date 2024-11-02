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

            $degrees = Degree::all();
            $sections = Sections::all();
            $users = User::all();

            $students = Student::whereIn('state', [0, 1])
                ->when($degreeId, function ($query) use ($degreeId) {
                    // Filtra por grado solo si degreeId no es null
                    return $query->whereHas('assignments', function ($query) use ($degreeId) {
                        $query->where('degrees_id', $degreeId);
                    });
                })
            ->when($search, function ($query) use ($search) {
                // Filtra por nombre solo si search no es null
                return $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                          ->orWhere('second_name', 'LIKE', "%{$search}%")
                          ->orWhere('first_lastname', 'LIKE', "%{$search}%")
                          ->orWhere('second_lastname', 'LIKE', "%{$search}%");
                });
            })
                ->with('assignments')
                ->paginate(10)
            ->appends([
                'degree_id' => $degreeId,
                'search' => $search,
            ]);

            foreach ($students as $student) {
                if ($student && $student->assignments->isNotEmpty()) {
                    $firstAssignment = $student->assignments->first();

                    // Buscamos el nombre del degree y section usando los IDs
                    $degreeName = $degrees->firstWhere('id', $firstAssignment['degrees_id'])->name ?? 'N/A';
                    $sectionName = $sections->firstWhere('id', $firstAssignment['section_id'])->name ?? 'N/A';

                    $student->degree_name = $degreeName;
                    $student->section_name = $sectionName;
                }
            }

            $collaborations = Collaborations::where('state', 1)->get();
            $months = Constants::MONTHS;

            return view('payments.listPayments', [
                'students' => $students,
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

            $singlePayment = null; // Variable para almacenar un solo pago en caso de que no haya meses

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
                $singlePayment = Payments::create([
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

                $paymentsCollection->push($singlePayment);
            }

            $degrees = Degree::all();
            $sections = Sections::all();
            $users = Auth::user()->username; // Obtiene solo el campo username

            $students = Student::with('assignments')->findOrFail($validatedData['student_id']);
            $students->state = $validatedData['type_payment'] === 'inscripcion' ? 0 : 1;
            $students->save();

            if ($students && $students->assignments->isNotEmpty()) {
                $firstAssignment = $students->assignments->first();

                // Buscamos el nombre del degree y section usando los IDs
                $degreeName = $degrees->firstWhere('id', $firstAssignment['degrees_id'])->name ?? 'N/A';
                $sectionName = $sections->firstWhere('id', $firstAssignment['section_id'])->name ?? 'N/A';

                $students->degree_name = $degreeName;
                $students->section_name = $sectionName;
            }

            // Generar los datos para el PDF
            $data = [
                'payments' => $paymentsCollection,
                'singlePayment' => $singlePayment,
                'student' => $students,
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
            session()->flash('paid_student_id', $validatedData['student_id']);


            return redirect('/payments')->with('message', 'El pago se registró con éxito.');

        } catch (\Exception $e) {
            Log::error('Error al crear el pago o actualizar el estudiante: ' . $e->getMessage());
            return redirect('/payments')->with('error', 'Ocurrió un problema al crear el pago. ' . $e->getMessage());
        }
    }

    public function listPaymentStudent($id)
    {
        $payments = Payments::where('student_id', $id)->with('student')->get();

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
