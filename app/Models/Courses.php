<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }

    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'tb_assign_courses_teachers', 'course_id', 'degree_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Sections::class, 'tb_assign_courses_teachers', 'course_id', 'section_id');
    }

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

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'tb_assign_courses_teachers')
                    ->withPivot('section_id', 'grade_id')
                    ->withTimestamps();
    }
}
