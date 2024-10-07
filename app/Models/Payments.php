<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payment_type',
        'payment_date',
        'grade_id',
        'section_id',
        'payment_months',
        'total_amount',

    ];

}
