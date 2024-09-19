<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function desactivar()
    {
        $this->state = 0;
        $this->save();
    }
}
