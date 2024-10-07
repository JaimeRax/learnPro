<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use App\Models\Degree;
use App\Models\Payments;
use App\Models\User;
use App\Models\Sections;
use NumberFormatter;


class paymentsController extends Controller
{
    public function listPayments()
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
                ->paginate(10)
                ->appends([
                    'degree_id' => $degreeId,
                    'search' => $search
                ]);


            } else {
                $student = Student::whereIn('state', [1,2])->paginate(10);
            }

            $degrees = Degree::all();
            $sections = Sections::all();
            $users = User::all();

            return view('payments.listPayments', [
               'student' => $student,
                'degrees' => $degrees,
                'sections' => $sections,
                'users' => $users,
            ]);

        } catch (\Exception $e) {
            return redirect('/payments')->with('error', 'Ocurrió un problema.');
        }


    }

    public function createPayments(Request $request,$id)
    {

        $student = Student::findOrFail($id);
        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();


        return view('payments.newPayment', [
            'student' => $student,
             'degrees' => $degrees,
             'sections' => $sections,
             'users' => $users,
         ]);
    }

    public function pdf_generator_get($id){

        $payments= Student::findOrFail($id);

    // Crear datos para el PDF
    $data = [
        'title' => 'Welcome to Payments',
        'date' => date('m/d/y'),
        'payments' => collect([$payments]) // Envolver el estudiante en una colección
    ];

        $pdf= PDF::loadview('pdf.myPDF', $data);
        return $pdf->download('pagos.pdf');

    }

    public static function money($number) {
        return NumberFormatter::create('es_GT', NumberFormatter::CURRENCY)->format($number);
    }

}
