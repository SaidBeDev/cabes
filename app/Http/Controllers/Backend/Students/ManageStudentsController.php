<?php

namespace App\Http\Controllers\Backend\Students;

use jsValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\OpeningHours\OpeningHours;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Backend\BackendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\DairasRepository\DairaRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\WilayasRepository\WilayaRepository;

use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

use Sentinel;

class ManageStudentsController extends BackendBaseController
{

    /**
     * @var StudentRepository
     */

    protected $repository;

    public function __construct(
        StudentRepository $repository,
        UserRepository $userRepository,
        ProfileTypeRepository $profileTypesRepository,
        DairaRepository $dairaRepository,
        WilayaRepository $wilayaRepository,
        ConfigRepository $configRepository,
        StudyYearRepository $studyYearRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['DairasRepository'] = $dairaRepository;
        $this->repositories['WilayasRepository'] = $wilayaRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearRepository;

        $this->setRubricConfig('students');
    }

    /**
     * Show all teachers with actions
     */
    public function index() {
        $data = [
            'list_students' => $this->repositories['UsersRepository']->whereHas('profile_type', function(Builder $query){
                $query->where('name', '=', 'student');
            })->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($id) {

        $user = $this->repositories['UsersRepository']->find($id);


        $data = [
            'user' => $user
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }

    public function edit($id) {

        $user = $this->repositories['UsersRepository']->find($id);

        $data = [
            'user' => $user,
            'profile_types' => $this->repositories['ProfileTypesRepository']->all(),
            'study_years' => $this->repositories['StudyYearsRepository']->all(),
            'list_dairas' => $this->repositories['DairasRepository']->all(),
            'validator' => jsValidator::make(array_merge($this->getUsersRules(), $this->getStudentRules()))
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * Update a user instance after validation.
     *
     * @param  Request  $request
     */
    protected function update(Request $request, $id, $profileId)
    {
        $newUser = $request->validate($this->getUsersRules());

        $this->repositories['UsersRepository']->update($newUser, $id);

        // Get the type of the profile
        $profile_type = $this->repositories['ProfileTypesRepository']->find($request->profile_type_id);

        switch ($profile_type->name) {

            case 'student':
                /* $student = $this->repository->find($profileId); */

                $credentials = $request->validate($this->getStudentRules());

                $this->repository->update($credentials, $profileId);

                $response = [
                    'success' => true,
                    'message' => trans('notifications.student_profile_updated')
                ];

                return redirect()->route('backend.students.index')->with($response);
                break;
        }

        $response = [
            'success' => true,
            'message' => trans('notifications.profile_updated')
        ];

        return redirect()->route('backend.students.index')->with($response);
    }

    /**
     * Edit Student's credit view
     */
    public function editCredit($id) {

        $data = [
            'student' => $this->repositories['UsersRepository']->find($id)
        ];

        return view($this->base_view . 'editCredit', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Change Student's credit
     */
    public function changeCredit(Request $request, $id) {

        if (!empty($request->credit) && is_numeric($request->credit)) {
            $this->repositories['UsersRepository']->update(['credit' => $request->credit], $id);

            $response = [
                'success' => true,
                'message' => trans('notifications.credit_updated')
            ];

            return response()->json($response);
        }
    }


    /**
     * Block a teacher account
     */
    public function toggleBlock(Request $request, $id) {

        if ($this->isBoolean($request->is_blocked)) {
            $user = $this->repositories['UsersRepository']->find($id);
            $user->is_blocked = $request->is_blocked;
            $user->save();

            $response = [
                'success' => true,
                'message' => $request->is_blocked == 1 ? trans('notifications.account_blocked') : trans('notifications.account_unblocked')
            ];

            return response()->json($response);
        }
        else {

            $response = [
                'success' => false,
                'message' => trans('notifications.error_occured')
            ];

            return response()->json($response);
        }

    }

    public function showHistory($id) {
        $data = [
            'student' => $this->repository->find($id),
            'list_sessions' => $this->repository->find($id)->first()->sessions()
        ];

        return view($this->base_view . 'history', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Rules
     */
    public function getUsersRules() {
        return [
            'full_name'       => 'required',
            /* 'email'           => 'required|email|unique:users',
            'password'        => 'string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/', */
            'tel'             => 'required',
            'address'         => 'required',
            'profile_type_id' => 'required',

        ];
    }

    public function getStudentRules() {
        return [
            'study_year_id' => 'required'
        ];
    }
}
