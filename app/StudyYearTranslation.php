<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class StudyYearTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['name', 'slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
