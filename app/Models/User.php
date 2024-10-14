<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Courses;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'dpi',
        'phone',
        'academic_degree',
        'service_time',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
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

    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'tb_assign_courses', 'teachers_id', 'course_id')
                    ->withPivot('section_id', 'degree_id') // Incluye las columnas adicionales
                    ->withTimestamps(); // Si deseas registrar las fechas de creación y actualización
    }

}
