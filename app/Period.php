<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public function sessions() {
        return $this->belongsToMany('App\Session', 'sessions_periods', 'period_id', 'session_id');
    }
}
