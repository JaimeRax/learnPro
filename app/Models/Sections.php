<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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

    public function degree()
    {
        return $this->hasMany('Degree', 'section_id', 'id');
    }

    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'tb_assign_courses_teachers', 'section_id', 'course_id');
    }

    public function student()
    {
        return $this->hasMany('tb_student', 'section_id', 'id');
    }
}
