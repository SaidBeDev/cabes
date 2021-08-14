<?php

namespace App\Http\Controllers\Backend\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;

use App\SaidTech\Repositories\ContactsRepository\ContactRepository;
use App\SaidTech\Repositories\ContactTypesRepository\ContactTypeRepository;

use jsValidator;

class ContactUsController extends BackendBaseController
{
    /**
     * @var ContactRepository
     */

    protected $repository;

    public function __construct(
        ContactRepository $repository,
        ContactTypeRepository $contactTypeRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['ContactTypesRepository'] = $contactTypeRepository;

        $this->setRubricConfig('contact');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = [
            'title' => $this->title
        ];

        $data = [
            'list_contacts' => $this->repository->orderBy('contact_type_id')->findWhere(['add_homepage' => 1])->all(),
            'contact_types' => $this->repositories['ContactTypesRepository']->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info = [
            'title' => $this->title
        ];

        $data = [
            'contact_types' => $this->repositories['ContactTypesRepository']->all()
        ];

        return view($this->base_view . 'create', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $contact = $request->validate($this->getContactRules($request));

        $contact['add_homepage'] = 1;

        $res = $this->repository->create($contact);

        if ($res) {
            $response = [
                'success' => true,
                'message' => trans('notifications.contact_added')
            ];


        }else {
            $response = [
                'success' => false,
                'message' => trans('notifications.error_occured')
            ];
        }

        return redirect()->route('backend.contact.index')->with($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = [
            'title' => $this->title
        ];

        $data = [
            'contact'       => $this->repository->find($id),
            'contact_types' => $this->repositories['ContactTypesRepository']->all()
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newContact = $request->validate($this->getContactUpdateRules());

        $status = $this->repository->update($newContact, $id);

        if(!$status)
            return redirect()->route('backend.contact.index')->with(['success' => false,'message' => trans('notifications.error_occured')]);

        return redirect()->route('backend.contact.index')->with(['success' => true,'message' => trans('notifications.contact_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json(['success' => true,'message' => trans('notifications.contact_deleted')]);
    }

    public function getContactRules($req) {
        $str = "required";
        $type = $this->repositories['ContactTypesRepository']->find($req->contact_type_id)->name;

        if (in_array($type, ['facebook', 'linkedin', 'instagram', 'youtube', 'twitter'])) {
            $str = "required|url";
        }

        if ($type == "email") {
            $str = "required|email";
        }

        return [
            'content' => $str,
            'contact_type_id' => 'required',

        ];
    }
    public function getContactUpdateRules() {
        return [
            'content' => 'required',
        ];
    }
}
