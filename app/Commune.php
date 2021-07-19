<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    //

    public function daira() {
        return $this->belongsTo('App\Daira');
    }
}
