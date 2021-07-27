<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desc', 'is_checked', 'module_id', 'hour_price', 'group_price',
        'availability_hours', 'portfolio'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
/*
    public function sessions() {
        return $this->hasMany('App\Session', 'id', 'session_id');
    } */

    public function modules() {
        return $this->belongsToMany('App\Module', 'modules_teachers', 'module_id', 'teacher_id');
    }

    public function sectors() {
        return $this->belongsToMany('App\Sector', 'sectors_teachers', 'sector_id', 'teacher_id');
    }

    public function teaching_years() {
        return $this->belongsToMany('App\StudyYear', 'years_teachers', 'year_id', 'teacher_id');
    }

    public function sessions() {
        return $this->hasMany('App\Session', 'teacher_id', 'id');
    }

    public function shedules() {
        return $this->hasMany('App\Shedule', 'teacher_id', 'id');
    }

}
