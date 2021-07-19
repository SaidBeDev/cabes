<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use \Dimsav\Translatable\Translatable;

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'slug'];
    protected $fillable = ['slug', 'color', 'bg_color', 'image'];

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
        return $this->belongsToMany('App\TeacherProfile', 'modules_teachers', 'teacher_id', 'module_id');
    }

    public function sessions() {

        return $this->hasMany('App\Session', 'module_id', 'id');
    }

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($module) { // before delete() method call this
             $module->deleteTranslations();
             // do the rest of the cleanup...
        });
    }

}
