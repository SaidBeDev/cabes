<?php

namespace App\SaidTech\Repositories\UsersRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "Cartalyst\\Sentinel\\Users\\EloquentUser";
    }
}
