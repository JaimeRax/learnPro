<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;

    protected $fillable = [
        'courses_id',
        'activity_1',
        'activity_2',
        'activity_3',
        'improvement_1',
        'improvement_2',
        'improvement_3',
        'discipline',
        'extracurricular',
        'exam',
        'student_id'
    ];

    public function student()
    {
        return $this->belongsTo('tb_student', 'student_id', 'id');
    }


    public function degree()
    {
        return $this->belongsTo('Degree', 'degree_id', 'id');
    }

}
