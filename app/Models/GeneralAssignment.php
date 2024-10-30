<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralAssignment extends Model
{
    use HasFactory;
    protected $table = 'tb_general_assignment';


    protected $fillable = [
        'course_id',
        'degrees_id',
        'section_id',
        'teachers_id',
    ];

    public function studentAssignments()
    {
        return $this->hasMany(StudentAssignment::class, 'general_assignment_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'general_assignment_id');
    }

}
