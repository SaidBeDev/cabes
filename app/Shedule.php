<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shedule extends Model
{
    protected $fillable = ['date', 'teacher_id', 'period_id', 'status_id', 'day', 'uri'];

    public $timestamps = false;
    /**
     * Relations
     */

     public function periods() {
         return $this->hasMany('App\Period', 'id', 'period_id');
     }

     public function status() {
         return $this->hasOne('App\Statuses', 'id', 'status_id');
     }

    public function session() {
        return $this->belongsTo('App\Session', 'uri', 'id');
     }
}
