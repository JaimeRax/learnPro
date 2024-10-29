<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Ratings;
use App\Models\Student;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\GeneralAssignment;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function listRatings() {
        try {
            $user = Auth::user();

            $degreeId = request()->query('degree_id');
            $sectionId = request()->query('section_id');
            $search = request()->query('search');

            if ($user && $user->hasRole('docente')) {

                $generalAssignments = GeneralAssignment::where('teachers_id', $user->id)
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degrees_id', $degreeId);
                    })
                    ->when($sectionId, function ($query) use ($sectionId) {
                        return $query->where('section_id', $sectionId);
                    })
                    ->pluck('id');

                    $students = Student::whereIn('state', [1, 2])
                    ->whereHas('studentAssignments', function ($query) use ($generalAssignments) {
                        return $query->whereIn('general_assignment_id', $generalAssignments);
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

                return view('ratings.listRatings', [
                    'students' => $students,
                    'degrees' => $degrees,
                    'sections' => $sections,
                ]);
            }

            return redirect('/ratings');
        } catch (\Exception $e) {
            return redirect('/ratings');
        }
    }

}
