<?php

namespace App\SaidTech\Repositories\TeachersRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class TeacherRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\TeacherProfile";
    }
}
