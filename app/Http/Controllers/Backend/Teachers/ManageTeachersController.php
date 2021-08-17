<?php

namespace App\Http\Controllers\Backend\Teachers;

use App\Sector;

use jsValidator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


use App\SaidTech\Traits\Auth\RegisterTrait;

use App\SaidTech\Traits\Data\avatarsTrait as Avatar;
use App\Http\Controllers\Backend\BackendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\DairasRepository\DairaRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\PeriodsRepository\PeriodRepository;
use App\SaidTech\Repositories\WilayasRepository\WilayaRepository;
use  App\SaidTech\Traits\Data\businessHoursTrait as businessHours;

use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\TeachersRepository\TeacherRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class ManageTeachersController extends BackendBaseController
{
    use businessHours, RegisterTrait, Avatar;

    /**
     * @var TeacherRepository
     */

    protected $repository;

    public function __construct(
        TeacherRepository $repository,
        UserRepository $userRepository,
        ProfileTypeRepository $profileTypesRepository,
        DairaRepository $dairaRepository,
        WilayaRepository $wilayaRepository,
        ConfigRepository $configRepository,
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        SessionRepository $sessionRepository,
        PeriodRepository $periodsRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['DairasRepository'] = $dairaRepository;
        $this->repositories['WilayasRepository'] = $wilayaRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;
        $this->repositories['SessionRepository'] = $sessionRepository;
        $this->repositories['PeriodsRepository'] = $periodsRepository;

        $this->setRubricConfig('teachers');
    }

    /**
     * Show all teachers with actions
     */
    public function index() {

        $data = [
            'list_teachers' => $this->repositories['UsersRepository']->whereHas('profile_type', function(Builder $query){
                $query->where('name', '=', 'teacher');
            })->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($id) {

        $user = $this->repositories['UsersRepository']->find($id);

        $data = [
            'user' => $user,
            'list_periods' => $this->repositories['PeriodsRepository']->all(),
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }

    public function edit($id) {

        $user = $this->repositories['UsersRepository']->find($id);

        $data = [
            'user' => $user,
            'profile_types' => $this->repositories['ProfileTypesRepository']->all(),
            'list_modules' => $this->repositories['ModulesRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_modules' => $this->repositories['ModulesRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),
            'study_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),
            'list_sectors' => Sector::all(),
            'list_avatars' => $this->getAvatars(),
            'list_periods' => $this->repositories['PeriodsRepository']->all(),
            'list_dairas' => $this->repositories['DairasRepository']->all(),
            'validator' => jsValidator::make(array_merge($this->getUsersRules(), $this->getTeacherRules()))
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * Update a user instance after validation.
     *
     * @param  Request  $request
     * @param  integer  $id
     */
    protected function update(Request $request, $id, $profileId)
    {

        $newUser = $request->validate($this->getUsersRules());

        /* if (!Hash::check($request->password, $oldUser->password)) {
            $newPassword = Hash::make($request->password);
            $newUser['password'] = $newPassword;

        } else{
            $newUser['password'] = $oldUser->password;
        } */

        $this->repositories['UsersRepository']->update($newUser, $id);

        // Get the type of the profile
        $profile_type = $this->repositories['ProfileTypesRepository']->find($request->profile_type_id);

        switch ($profile_type->name) {
            case 'teacher':

                $teacher = $this->repository->find($profileId);

                $credentials = $request->validate($this->getTeacherRules());

                $teacher->desc = $request->desc;
                $teacher->diploma = $request->diploma;
                $teacher->experience = $request->experience;
                $teacher->video_link = $request->video_link;
                $teacher->portfolio = $request->portfolio;

                $teacher->save();

                // Modules
                if (!empty($teacher->modules)) {
                   for ($i = 0; $i < count($teacher->modules); $i++) {
                        $teacher->modules()->detach();
                    }
                }


                for ($i = 0; $i < count($request->module_id); $i++) {
                    $teacher->modules()->attach($request->module_id[$i]);
                }

                 // Sectors
                 if (!empty($teacher->sectors)) {
                    for ($i = 0; $i < count($teacher->sectors); $i++) {
                        $teacher->sectors()->detach();
                    }
                 }

                 for ($i = 0; $i < count($request->sector); $i++) {
                     $teacher->sectors()->attach($request->sector[$i]);
                 }

                // Teaching Years
                if (!empty($teacher->teaching_years)) {
                    for ($i = 0; $i < count($teacher->teaching_years); $i++) {
                         $teacher->teaching_years()->detach();
                     }
                 }

                 for ($i = 0; $i < count($request->teaching_years); $i++) {
                     $teacher->teaching_years()->attach($request->teaching_years[$i]);
                 }

                $response = [
                    'success' => true,
                    'message' => trans('notifications.profile_updated')
                ];

                return redirect()->route('backend.teachers.index')->with($response);
                break;
        }

        $response = [
            'success' => true,
            'message' => trans('notifications.profile_updated')
        ];

        return redirect()->route('backend.teachers.index')->with($response);
    }

    /**
     * Mark a teacher as verified
     */
    public function toggleCheck(Request $request, $id) {

        if ($this->isBoolean($request->is_checked)) {
            $teacher = $this->repository->find($id);
            $teacher->is_checked = $request->is_checked;
            $teacher->save();

            $response = [
                'success' => true,
                'message' => $request->is_checked == 1 ? trans('notifications.account_verified') : trans('notifications.account_unverified')
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

      /**
     * Change teacher weekly planning
     */
    public function editHourPrices($id) {

        $data = [
            'user' => $this->repositories['UsersRepository']->find($id)
        ];

        return view($this->base_view . 'editHours', ['data' => array_merge($this->data, $data)]);
    }

      /**
     * Change teacher weekly planning
     */
    public function editAvailability($id) {
        $availability = $this->repository->find($id)->first()->avalability_hours;

        $data = [
            'availability' => unserialize($availability),
            'list_status' => $this->getAvailabilityStatus()
        ];

        return view($this->base_view . 'editAvailability', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Change teacher weekly planning
     */
    public function updateAvailability(Request $request, $id) {

        if (empty($request->avalibility_hours)) {
            $teacher = $this->repositories['TeacherRepository']->find($id)->update(['avalibility_hours' => $request->avalibility_hours]);
        }else {
            throw new \LogicException('Availability hours cant be null, expected json');
        }

        $response = [
            'success' => true,
            'message' => trans('notifications.availability_updated')
        ];

        return redirect()->route($this->base_view . 'edit', ['id' => $id])->with($response);
    }

    /**
     * Change teacher's hourly price
     */
    public function changeHourlyPrice(Request $request, $id) {

        if (!empty($request->hour_price) && is_numeric($request->hour_price)) {
            $teacher = $this->repository->find($id);
            $teacher->hour_price = $request->hour_price;

            $teacher->save();

            $response = [
                'success' => true,
                'message' => trans('notifications.hour_price_updated')
            ];

            return response()->json($response);
        } else {

            $response = [
                'success' => false,
                'message' => trans('notifications.error_occured')
            ];

            return response()->json($response);
        }

    }

    /**
     * Change teacher's session price
     */
    public function changeGroupPrice(Request $request, $id) {

        if (!empty($request->group_price) && is_numeric($request->group_price)) {
            $teacher = $this->repository->find($id);
            $teacher->group_price = $request->group_price;

            $teacher->save();

            $response = [
                'success' => true,
                'message' => trans('notifications.group_price_updated')
            ];

            return response()->json($response);
        }

    }

    /**
     * Edit teacher's credit view
     */
    public function editCredit($id) {

        $data = [
            'teacher' => $this->repositories['UsersRepository']->find($id)
        ];

        return view($this->base_view . 'editCredit', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Update teacher's credit
     */
    public function changeCredit(Request $request, $id) {

        if (!empty($request->credit) && is_numeric($request->credit)) {
            $user = $this->repositories['UsersRepository']->find($id);
            $user->credit = $request->credit;
            $user->save();

            $response = [
                'success' => true,
                'message' => trans('notifications.credit_updated')
            ];

            return response()->json($response);
        }
        else {
            $response = [
                'success' => false,
                'message' => trans('notifications.rule_numeric')
            ];

            return response()->json($response);
        }

        $response = [
            'success' => false,
            'message' => trans('notifications.error_occured')
        ];

        return response()->json($response);

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

    /**
     * Show teacher's history (sessions)
     */
    public function showHistory($id) {
        $data = [
            'teacher' => $this->repository->find($id),
            'list_sessions' => $this->repositories['SessionRepository']->findWhere(['teacher_id' => $id])->all()
        ];

        return view($this->base_view . 'showHistory', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Rules for storing
     */
    public function getUsersRules() {
        return [
            'full_name'       => 'required',
            'tel'             => 'required',
            'address'         => 'required',
            'profile_type_id' => 'required',

        ];
    }

    public function getTeacherRules() {
        return [
            'desc' => 'nullable',
            'diploma' => "nullable",
            'experience' => "nullable",
            'video_link' => "nullable",
            'portfolio' => "nullable"
        ];
    }
}
