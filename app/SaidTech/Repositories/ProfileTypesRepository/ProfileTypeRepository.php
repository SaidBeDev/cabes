<?php

namespace App\SaidTech\Repositories\ProfileTypesRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class ProfileTypeRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\ProfileType";
    }
}
