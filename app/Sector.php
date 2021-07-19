<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
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
        return $this->belongsToMany('App\TeacherProfile', 'sectors_teachers', 'teacher_id', 'sector_id');
    }

     // this is a recommended way to declare event handlers
     public static function boot() {
        parent::boot();

        static::deleting(function($sector) { // before delete() method call this
             $sector->deleteTranslations();
             // do the rest of the cleanup...
        });
    }
}
