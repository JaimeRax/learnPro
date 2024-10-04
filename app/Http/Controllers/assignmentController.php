<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use App\Models\Degree;


class assignmentController extends Controller
{
    public function listAssignment()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $student = Student::where('state', 2)
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
                $student = Student::where('state', 2)->paginate(10);
            }

            $degrees = Degree::all();

            return view('assignment.listAssignment', [
               'student' => $student,
                'degrees' => $degrees,
            ]);

        } catch (\Exception $e) {
            return redirect('/student')->with('error', 'Ocurrió un problema.');
        }


    }

}
