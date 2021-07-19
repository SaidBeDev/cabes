<?php

namespace App\SaidTech\Repositories\ModulesRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class ModuleRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Module";
    }
}
