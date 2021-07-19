<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ["content", "contact_type_id"];

    public function contact_type() {
        return $this->hasOne('App\ContactType', 'id', 'contact_type_id');
    }

    public function users() {
        return $this->belongsToMany('Cartalyst\Sentinel\Users\EloquentUser', 'users_contacts', 'user_id', 'contact_id');
    }
}
