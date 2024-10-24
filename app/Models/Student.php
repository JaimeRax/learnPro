<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'tb_student';

    protected $fillable = [
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'personal_code',
        'gender',
        'birthdate',
        'town_ethnicity',
    ];

    public function in_charge()
    {
        return $this->hasMany('tb_in_charge', 'student_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'student_id', 'id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany('tb_ratings', 'student_id', 'id');
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
