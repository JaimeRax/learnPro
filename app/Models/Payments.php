<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Student;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'tb_payments';

    protected $fillable = [
        'type_payment',
        'mood_payment',
        'payment_date',
        'name_collaboration',
        'description',
        'uuid',
        'amount',
        'bank',
        'paid_month',
        'year',
        'document_number',
        'comment',
        'student_id',
        'user_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }


}
