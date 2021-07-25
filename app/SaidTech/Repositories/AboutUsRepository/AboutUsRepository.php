<?php

namespace App\SaidTech\Repositories\AboutUsRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class AboutUsRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\About";
    }
}
