<?php

namespace App;

use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'addrees', 'tel', 'birthday', 'avatar', 'credit', 'commune_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relations
     */

    public function profile_type() {
        return $this->hasOne('App\ProfileType', 'id', 'profile_type_id');
    }

    public function student() {
        return $this->hasOne('App\StudentProfile', 'user_id', 'id');
    }

    public function teacher() {
        return $this->hasOne('App\TeacherProfile', 'user_id', 'id');
    }

    public function commune() {
        return $this->hasOne('App\Commune', 'id', 'commune_id');
    }

    public function study_year() {
        return $this->hasOne('App\StudyYear', 'id', 'study_year_id');
    }

    public function modules() {
        return $this->belongsToMany('App\Module', 'modules_teachers', 'module_id', 'teacher_id');
    }

    public function contacts() {
        return $this->belongsToMany('App\Contact', 'users_contacts', 'contact_id', 'user_id');
    }

    public function getSocialCntacts() {
        return $this->contacts->filter(function($contact) {
            return in_array($contact->contact_type->name, ['facebook', 'twitter', 'linkedin', 'instagram', 'viber', 'whatsapp']);
        });
    }

}
