<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nbr_hours', 'credit_cost', 'hour_from', 'hour_to', 'student_id', 'teacher_id'
    ];

    /**
     * Relations
     */

    public function student_profile() {
        return $this->hasOne('App\StudentProfile', 'id', 'student_id');
    }

    public function teacher_profile() {
        return $this->hasOne('App\TeacherProfile', 'id', 'teacher_id');
    }

}
