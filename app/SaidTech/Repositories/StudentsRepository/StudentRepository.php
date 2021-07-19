<?php

namespace App\SaidTech\Repositories\StudentsRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class StudentRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\StudentProfile";
    }
}
