<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\ContactsRepository\ContactRepository;

use App\SaidTech\Traits\Files\UploadImageTrait as uploadImage;

class ContactController extends FrontendBaseController
{

     /**
     * @var ContactRepository
     */

    protected $repository;

    public function __construct(
        ContactRepository $repository
    )
    {
        $this->repository = $repository;

        $this->setRubricConfig('contact');
    }


    public function index() {

        $data = [
            'list_contacts' => $this->repository->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }
}
