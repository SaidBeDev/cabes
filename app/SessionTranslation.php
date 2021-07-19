<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class SessionTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['title', 'desc', 'slug', 'objectives'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
