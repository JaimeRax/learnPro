<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralAssignment extends Model
{
    use HasFactory;


    protected $fillable = [
        'course_id',
        'degrees_id',
        'section_id',
        'teachers_id',
    ];

}
