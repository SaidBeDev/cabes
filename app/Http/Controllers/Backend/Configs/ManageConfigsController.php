<?php

namespace App\Http\Controllers\Backend\Configs;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\Validator;

use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;

class ManageConfigsController extends BackendBaseController
{

    /**
     * @var StudentRepository
     */

    protected $repository;

    public function __construct(
        ConfigRepository $repository
    )
    {
        $this->repository = $repository;

        $this->setRubricConfig('configs');
    }

    /**
     * Show all teachers with actions
     */
    public function index() {
        $data = [
            'list_configs' => $this->repository->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function update(Request $request, $id) {

        $request->validate(['content' => "required"]);

        $this->repository->update(['content' => $request->content], $id);

        $response = [
            'success' => true,
            'message' => trans('notifications.config_updated')
        ];

        return response()->json($response);


    }
}
