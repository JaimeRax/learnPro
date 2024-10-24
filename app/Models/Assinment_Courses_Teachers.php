<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinment_Courses_Teachers extends Model
{
    use HasFactory;
    protected $table = 'tb_assign_courses_teachers';


    protected $fillable = [
        'teachers_id',
        'course_id',
        'section_id',
        'degree_id',
    ];

    public function disable()
    {
        $this->state = 0;
        $this->save();
    }

    public function enable()
    {
        $this->state = 1;
        $this->save();
    }
}
