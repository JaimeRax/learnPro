<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class In_charge extends Model
{
    use HasFactory;
    protected $table = 'tb_in_charge';
    protected $fillable = [
        'charge_first_name',
        'charge_second_name',
        'charge_first_lastname',
        'charge_second_lastname',
        'charge_dpi',
        'charge_phone',
        'charge_address',
        'charge_relationship',
        'charge_comment',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo('tb_student', 'student_id', 'id');
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
