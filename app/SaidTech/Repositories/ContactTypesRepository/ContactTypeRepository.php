<?php

namespace App\SaidTech\Repositories\ContactTypesRepository;

use Prettus\Repository\Eloquent\BaseRepository;

class ContactTypeRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\ContactType";
    }
}
