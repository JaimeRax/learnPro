<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'tb_student';

    protected $fillable = ['first_name', 'second_name', 'first_lastname', 'second_lastname', 'personal_code', 'gender', 'birthdate', 'town_ethnicity'];

    public function in_charge()
    {
        return $this->hasMany(In_charge::class, 'student_id', 'id');
    }

    public function inCharge()
    {
        return $this->hasOne(In_charge::class); // Ajusta el tipo de relación según tu estructura de base de datos
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'student_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(StudentAssignment::class, 'student_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class, 'student_id', 'id');
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

    public function studentAssignments()
    {
        return $this->hasMany(StudentAssignment::class);
    }

    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'tb_student_assignment', 'student_id', 'degree_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Sections::class, 'tb_student_assignment', 'student_id', 'section_id');
    }

    public function inCharges()
    {
        return $this->hasMany(In_charge::class, 'student_id', 'id');
    }
}
