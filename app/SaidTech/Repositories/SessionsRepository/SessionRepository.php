<?php

namespace App\SaidTech\Repositories\SessionsRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class SessionRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Session";
    }
}
