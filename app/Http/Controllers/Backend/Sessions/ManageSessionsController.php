<?php

namespace App\Http\Controllers\Backend\Sessions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\OpeningHours\OpeningHours;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Backend\BackendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\PeriodsRepository\PeriodRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class ManageSessionsController extends BackendBaseController
{

    /**
     * @var SessionRepository
     */

    protected $repository;

    public function __construct(
        SessionRepository $repository,
        UserRepository $userRepository,
        ProfileTypeRepository $profileTypesRepository,
        ConfigRepository $configRepository,
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        PeriodRepository $periodsRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['PeriodsRepository'] = $periodsRepository;
        $this->repositories['ModuleRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;

        $this->setRubricConfig('sessions');
    }

    public function getTeachers() {
        $data = [
            'list_teachers' => $this->repositories['UsersRepository']->whereHas('profile_type', function (Builder $query) {
                $query->where('name', 'teacher');
            })->all()
        ];

        return view($this->base_view . 'listTeachers', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Show all sessions with actions
     */
    public function index($id) {
        $data = [
            'list_sessions' => $this->repository->findWhere(['is_completed' => 0, 'is_canceled' => 0, 'teacher_id' => $id])->all()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Edit a session
     */
    public function edit($id) {
        $data = [
            'list_modules' => $this->repositories['ModuleRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_modules' => $this->repositories['ModuleRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),
            'study_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),

            'session' => $this->repository->find($id)
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * Update an existing Session
     * @param Request $request
     */
    public function update(Request $request, $id) {
        $oldSession = $this->repository->find($id);
        $session = $request->validate($this->getSessionUpdateRules());
        $session = $request->except(['title_fr', 'title_ar', 'desc_fr', 'desc_ar']);

        $session['teacher_id'] = $oldSession->teacher_id;

        $teacher = $oldSession->teacher;

        if (empty($teacher)) {
            throw new \LogicException('Unexpected teacher profile');
        }
        elseif ($teacher->is_blocked == 1) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }


         // Upload image
         if (isset($request->image)) {
            $image = $this->uploadImageAndMove($request->image, $oldSession->image, 'sessions', 'sessions', 'image');
            $session['image'] = $image;
        }

        $translations = [
            'ar' => ['title' => !empty($request->title_ar) ? $request->title_ar : $request->title_fr . ' 1', 'desc' => !empty($request->desc_ar) ? $request->desc_ar : $request->desc_fr, 'objectives' => !empty($request->objectives_ar) ? $request->objectives_ar : $request->objectives_fr],
            'fr' => ['title' => $request->title_fr, 'desc' => $request->desc_fr, 'objectives' => $request->objectives_fr]
        ];

        $this->repository->update(array_merge($session, $translations), $id);

        $response = [
            'success' => true,
            'message' => trans('notifications.session_updated')
        ];

        return redirect()->route('backend.sessions.index', ['id' => $teacher->id])->with($response);
    }

    /**
     *
     */
    public function show($id) {
        $data = [
            'session' => $this->repository->find($id)
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * List of enrolled students
     */
    public function getEnrolledStudents($id) {

        $data = [
            'session' => $this->repository->find($id),
            'title' => trans('frontend.enrolled_list')
        ];

        return view($this->base_view . 'enrolledStudents', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * List of completed sessions
     */
    public function getCompletedSessions($id) {

        $list_sessions = $this->repository->findWhere(['is_completed' => 1, 'teacher_id' => $id])->groupBy('id');

        $session_per  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_percentage'])->first()->content;

        $total = 0;

        foreach ($list_sessions as $key => $sessions) {
            $total_credit = 0;

            foreach ($sessions as $session) {
                foreach ($session->students as $student) {
                    $total_credit += (int)$session->credit_cost * ((100 - $session_per) / 100);
                }
            }

            $total += $total_credit;

            $list_sessions[$key]['total_credit'] = $total_credit;
        }

        $data = [
            'list_sessions' => $list_sessions,
            'total' => $total,
            'title' => trans('frontend.completed_sessions')
        ];

        return view($this->base_view . 'completedSessions', ['data' => array_merge($this->data, $data)]);
    }
    /**
     * List of canceled sessions
     */
    public function getCanceledSessions($id) {

        $list_sessions = $this->repository->findWhere(['is_canceled' => 1, 'teacher_id' => $id])->groupBy('id');

        $cancel_pen  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_cancel_penality'])->first()->content;

        $total = 0;

        foreach ($list_sessions as $key => $sessions) {
            $total_credit = $cancel_pen;

            $total += $total_credit;

            $list_sessions[$key]['total_credit'] = $total_credit;
        }

        $data = [
            'list_sessions' => $list_sessions,
            'title' => trans('frontend.canceled_sessions'),
            'total' => $cancel_pen
        ];

        return view($this->base_view . 'canceledSessions', ['data' => array_merge($this->data, $data)]);
    }

    public function getSessionRules() {
        return [
            'title_fr' => 'required',
            'desc_fr'  => 'required',
            'objectives_fr' => 'required',
            'link'  => 'required',
            'g_link'  => 'nullable',
            'date' => 'required|date',
            'teacher_id' => 'required|numeric',
            'module_id' => 'required|numeric',
            'period_id' => 'required',
            'study_year_id' => 'required|numeric'
        ];
    }

    public function getSessionUpdateRules() {
        return [
            'title_fr' => 'required',
            'desc_fr'  => 'required',
            'objectives_fr' => 'required',
            'link'  => 'required',
            'g_link'  => 'nullable',
            'teacher_id' => 'required|numeric',
            'module_id' => 'required|numeric',
            'study_year_id' => 'required|numeric'
        ];
    }
}
