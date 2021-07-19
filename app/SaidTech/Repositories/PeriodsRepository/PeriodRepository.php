<?php

namespace App\SaidTech\Repositories\PeriodsRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class PeriodRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Period";
    }
}
