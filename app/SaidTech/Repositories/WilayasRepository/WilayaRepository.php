<?php

namespace App\SaidTech\Repositories\WilayasRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class WilayaRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Wilaya";
    }
}
