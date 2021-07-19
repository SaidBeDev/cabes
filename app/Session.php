<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Session extends Model
{
    use \Dimsav\Translatable\Translatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'desc', 'slug', 'objectives'];
    protected $fillable = [
        'slug', 'capacity', 'nbr_hours', 'credit_cost', 'link', 'image', 'date', 'is_canceled', 'is_completed', 'teacher_id', 'module_id', 'period_id', 'study_year_id'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // (optionaly)
    protected $with = ['translations'];


    /**
     * Relations
     */
    public function teacher() {
        return $this->hasOne('App\TeacherProfile', 'id', 'teacher_id');
    }

    public function students() {
        return $this->belongsToMany('App\StudentProfile', 'sessions_students', 'session_id', 'student_id');
    }

    public function module() {
        return $this->hasOne('App\Module' , 'id', 'module_id');
    }

    public function period() {
        return $this->hasOne('App\Period' , 'id', 'period_id');
    }

    public function periods() {
        return $this->belongsToMany('App\Period', 'sessions_periods', 'session_id', 'period_id');
    }

    public function study_year() {
        return $this->hasOne('App\StudyYear' , 'id', 'study_year_id');
    }

    // Event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($session) { // before delete() method call this
             $session->deleteTranslations();
             // do the rest of the cleanup...
        });
    }
}
