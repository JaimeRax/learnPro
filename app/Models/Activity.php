<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'tb_activity';

    protected $fillable = [
        'name',
        'state',
        'plucking',
        'date_entity',
        'bimester',
        'year',
        'general_assignment_id',
        'state',
    ];

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

    public function generalAssignment()
{
    return $this->belongsTo(GeneralAssignment::class, 'general_assignment_id');
}


public function ratings()
{
    return $this->hasMany(Ratings::class, 'activity_id', 'id');
}


}
