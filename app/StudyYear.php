<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyYear extends Model
{

    use \Dimsav\Translatable\Translatable;

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'slug'];
    protected $fillable = ['slug'];

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
    public function teachers() {
        return $this->belongsToMany('App\TeacherProfile', 'years_teachers', 'teacher_id', 'year_id');
    }

    public function sessions() {

        return $this->hasMany('App\Session', 'study_year_id', 'id');
    }

}
