<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\ContactsRepository\ContactRepository;

use App\SaidTech\Traits\Auth\ContactTrait;
use Illuminate\Http\Request;

class ContactController extends FrontendBaseController
{
    use ContactTrait;

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

    /**
     * Send a contact email
     * @param Request $request
     *
     */
    public function store(Request $request) {
        $validateData = $request->validate($this->getContactRules());

        $res = $this->sendContactMail($validateData);

        if ($res) {
            $response = [
                'success' => true,
                'message' => trans('notifications.email_sent')
            ];

            return redirect()->back()->with($response);
        } else {

            $response = [
                'success' => false,
                'message' => trans('notifications.error_occured')
            ];

        return redirect()->back()->with($response);
        }

    }

    public function getContactRules() {
        return [
            'full_name' => "required",
            'email' => "required|email",
            'subject' => "nullable",
            'message' => "required",
        ];
    }
}
