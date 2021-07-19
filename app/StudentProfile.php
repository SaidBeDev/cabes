<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'study_year_id'
    ];

    /**
     * Relations
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function sessions() {
        return $this->belongsToMany('App\Session', 'sessions_students', 'student_id', 'session_id');
    }

    public function study_year() {
        return $this->hasOne('App\StudyYear', 'id', 'study_year_id');
    }
}
