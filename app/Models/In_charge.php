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
        'charge_first_name_2',
        'charge_second_name_2',
        'charge_first_lastname_2',
        'charge_second_lastname_2',
        'charge_dpi_2',
        'charge_phone_2',
        'charge_address_2',
        'charge_relationship_2',
        'charge_comment_2',
        'charge_first_name_3',
        'charge_second_name_3',
        'charge_first_lastname_3',
        'charge_second_lastname_3',
        'charge_dpi_3',
        'charge_phone_3',
        'charge_address_3',
        'charge_relationship_3',
        'charge_comment_3',
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
