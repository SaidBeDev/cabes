<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daira extends Model
{
    public function wilaya() {
        return $this->belongsTo('App\Wilaya');
    }

    public function communes() {
        return $this->hasMany('App\Commune');
    }
}
