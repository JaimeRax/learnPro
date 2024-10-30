<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    use HasFactory;
    protected $table = 'tb_student_assignment';


    protected $fillable = [
        'student_id',
        'general_assignment_id',
        'degrees_id',
        'section_id',
        'year',

    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function generalAssignment()
    {
        return $this->belongsTo(GeneralAssignment::class, 'general_assignment_id');
    }



}
