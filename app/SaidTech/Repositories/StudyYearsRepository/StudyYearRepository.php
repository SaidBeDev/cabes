<?php

namespace App\SaidTech\Repositories\StudyYearsRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class StudyYearRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\StudyYear";
    }
}
