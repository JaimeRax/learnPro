<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'degree_id',
    ];

    public function degree()
    {
        return $this->belongsTo('Degree', 'degree_id', 'id');
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
