<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\AboutUsRepository\AboutUsRepository;

use App\SaidTech\Traits\Files\UploadImageTrait as uploadImage;

class AboutUsController extends FrontendBaseController
{
    use uploadImage;

     /**
     * @var AboutUsRepository
     */

    protected $repository;

    public function __construct(
        AboutUsRepository $repository
    )
    {
        $this->repository = $repository;

        $this->setRubricConfig('about');
    }


    public function index() {

        $data = [
            'article' => $this->repository->first()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }
}
