<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
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
    ];

    public function in_charge()
    {
        return $this->hasMany('tb_in_charge', 'student_id', 'id');
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
