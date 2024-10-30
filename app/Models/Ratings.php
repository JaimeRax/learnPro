<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'tb_ratings';
    use HasFactory;

    protected $fillable = [
        'student_id',
        'activity_id',
        'score_obtained'
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
