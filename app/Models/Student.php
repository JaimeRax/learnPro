<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'tb_student';
    use HasFactory;

    protected $fillable = [
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'personal_code',
        'gender',
        'birthdate',
        'town_ethnicity',
        'degree_id',
    ];

    public function in_charge()
    {
        return $this->hasMany('tb_in_charge', 'student_id', 'id');
    }

    public function degree()
    {
        return $this->belongsTo('degrees', 'degree_id', 'id');
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