<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    public $timestamps = false;

    public function dairas() {
        return $this->hasMany('App\Daira');
    }
}
