<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'tb_payments';

    protected $fillable = [
        'type_payment',
        'mood_payment',
        'payment_date',
        'uuid',
        'amount',
        'bank',
        'month',
        'document_number',
        'comment',
        'student_id',
        'user_id',
    ];

    public function student()
    {
        return $this->belongsTo('tb_student', 'student_id', 'id');
    }


}
