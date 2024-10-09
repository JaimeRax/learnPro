<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $table = 'tb_monthly_payments';

    protected $fillable = [
        'payment_id', // Relación con tb_payments
        'month', // Almacena el número del mes
    ];

    // Relación con el modelo Payments
    public function payment()
    {
        return $this->belongsTo(Payments::class, 'payment_id');
    }
}
