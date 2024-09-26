<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class In_charge extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'dpi',
        'address',
        'relationship',
        'comment',
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
