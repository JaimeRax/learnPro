<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sections;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->hasMany('Courses', 'degree_id', 'id');
    }


    public function student()
    {
        return $this->hasMany('tb_student', 'degree_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany('tb_ratings', 'degree_id', 'id');
    }


    public function section()
    {
        return $this->belongsToMany(Sections::class, 'tb_student_assignment', 'degrees_id', 'section_id');
    }


    public function course()
{
    return $this->belongsToMany(Courses::class);
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

}
