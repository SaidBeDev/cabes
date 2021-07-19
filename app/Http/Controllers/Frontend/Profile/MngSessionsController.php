<?php

namespace App\Http\Controllers\Frontend\Profile;

use DateTime;
use App\Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Traits\Files\UploadImageTrait as uploadImage;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\PeriodsRepository\PeriodRepository;
use App\SaidTech\Traits\Data\businessHoursTrait as businessHours;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\TeachersRepository\TeacherRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;
use App\Shedule;

class MngSessionsController extends FrontendBaseController
{
    use businessHours, uploadImage;

    /**
     * @var SessionRepository
     */

    protected $repository;

    public function __construct(
        SessionRepository $repository,
        UserRepository $userRepository,
        StudentRepository $studentRepository,
        TeacherRepository $teacherRepository,
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        ProfileTypeRepository $profileTypesRepository,
        ConfigRepository $configRepository,
        PeriodRepository $periodsRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['StudentsRepository'] = $studentRepository;
        $this->repositories['TeacherRepository'] = $teacherRepository;
        $this->repositories['ModuleRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['PeriodsRepository'] = $periodsRepository;

        $this->setRubricConfig('profile');
    }

    /**
     * Show all teachers with actions
     */
    public function index() {

        $data = [
            'uri' => "my_courses",
            'title' => trans('menu.sessions'),
            'list_sessions' => Auth::user()->profile_type->name == "teacher" ? $this->repository->findWhere(['is_completed' => 0, 'is_canceled' => 0, 'teacher_id' => Auth::user()->teacher->id])->all() : Auth::user()->student->sessions
        ];

        return view($this->base_view . 'sessions.index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($id) {
        $data = [
            'uri' => "view_course",
            'session' => $this->repository->find($id)
        ];

        return view($this->base_view . 'sessions.show', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Redirect to create view
     */
    public function create() {

        $data =  [
            'uri' => "add_course",
            'list_modules' => $this->repositories['ModuleRepository']->all(),
            'study_years' => $this->repositories['StudyYearsRepository']->all(),
            'list_periods' => $this->repositories['PeriodsRepository']->all(),
            'default_capacity' => $this->repositories['ConfigsRepository']->findWhere(['name' => "group_capacity"])->first()->content
        ];

        return view($this->base_view . 'sessions.create', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Store a new Session
     * @param Request $request
     */
    public function store(Request $request) {

        $request->validate($this->getSessionRules());
        $session = $request->except(['title_fr', 'title_ar', 'desc_fr', 'desc_ar', 'objectives_ar', 'objectives_fr']);

        $teacher = $this->repositories['TeacherRepository']->find($request->teacher_id);

        if (empty($teacher)) {
            throw new \LogicException('Unexpected teacher profile');
        }
        elseif ($teacher->user->is_blocked == 1) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        /* Multiple periods to session start */

        $periodList = $this->repositories['PeriodsRepository']->orderBy('hour_from')->findWhereIn('id', $request->period_id);

        if (count($periodList) == 1) {
            $session['period_id'] = $periodList->first()->id;

            // Calculate Nbr hours
            $d1 = Carbon::createFromFormat('H:i', $periodList->first()->hour_from);
            $d2 = Carbon::createFromFormat('H:i', $periodList->first()->hour_to);

            $session['nbr_hours'] = $d2->floatDiffInRealHours($d1);

        } elseif (count($periodList) == 2) {
            // Calculate Nbr hours
            $d1 = Carbon::createFromFormat('H:i', $periodList->first()->hour_from);
            $d2 = Carbon::createFromFormat('H:i', $periodList->last()->hour_to);

            $session['nbr_hours'] = $d2->floatDiffInRealHours($d1);
        }

        /* End */
        // add period to session
        $session['period_id'] = $periodList->first()->id;

        $group_price  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => "group_price"])->first()->content;

        // Session credit cost calculate
        $session['credit_cost'] = (int)$session['nbr_hours'] * $group_price;

        // Upload image
        if (isset($request->image)) {
            $image = $this->uploadImage($request->image, 'sessions', 'sessions', 'image');
            $session['image'] = $image;
        }

        $translations = [
            'ar' => ['title' => !empty($request->title_ar) ? $request->title_ar : $request->title_fr, 'desc' => !empty($request->desc_ar) ? $request->desc_ar : $request->desc_fr, 'objectives' => !empty($request->objectives_ar) ? $request->objectives_ar : $request->objectives_fr],
            'fr' => ['title' => $request->title_fr, 'desc' => $request->desc_fr, 'objectives' => $request->objectives_fr]
        ];

        $res = $this->repository->create(array_merge($session, $translations));

        // Add periods to session
        $res->periods()->attach($request->period_id);


        if ($res) {
            $day = Carbon::createFromFormat('Y-m-d', $request->date);

            foreach ($periodList as $period) {
                $sh = [
                    'uri' => $res->id,
                    'day' => strtolower($day->format('l')),
                    'date' => $day->format('Y-m-d'),
                    'teacher_id' => $teacher->id,
                    'status_id' => 3,
                    'period_id' => $period->id
                ];

                Shedule::create($sh);
            }

        }

        $response = [
            'success' => true,
            'message' => trans('notifications.session_created')
        ];

        return redirect()->route('frontend.profile.sessions.index')->with($response);
    }

    /**
     * Edit a session
     * @param int $id
     */
    public function edit($id) {
        $data = [
            'uri' => 'my_courses',
            'study_years' => $this->repositories['StudyYearsRepository']->all(),
            'list_modules' => $this->repositories['ModuleRepository']->all(),
            'session' => $this->repository->find($id)
        ];

        return view($this->base_view . 'sessions.edit', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * Update an existing Session
     * @param Request $request
     */
    public function update(Request $request, $id) {
        $oldSession = $this->repository->find($id);
        $session = $request->validate($this->getSessionRules());
        $session = $request->except(['title_fr', 'title_ar', 'desc_fr', 'desc_ar']);

        $session['teacher_id'] = $oldSession->teacher_id;

        $teacher = $oldSession->teacher;

        if (empty($teacher) || Auth::user()->teacher->id != $oldSession->teacher_id) {
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
            'ar' => ['title' => !empty($request->title_ar) ? $request->title_ar : $request->title_fr, 'desc' => !empty($request->desc_ar) ? $request->desc_ar : $request->desc_fr, 'objectives' => !empty($request->objectives_ar) ? $request->objectives_ar : $request->objectives_fr],
            'fr' => ['title' => $request->title_fr, 'desc' => $request->desc_fr, 'objectives' => $request->objectives_fr]
        ];

        $this->repository->update(array_merge($session, $translations), $id);

        $response = [
            'success' => true,
            'message' => trans('notifications.session_updated')
        ];

        return redirect()->route('frontend.profile.sessions.index')->with($response);
    }

    /**
     * List of enrolled students
     */
    public function getEnrolledStudents($id) {

        $data = [
            'session' => $this->repository->find($id),
            'title' => trans('frontend.enrolled_list')
        ];

        return view($this->base_view . 'sessions.enrolledStudents', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * List of completed sessions
     */
    public function getCompletedSessions($id) {

        if (Auth::user()->profile_type->name == "teacher")
        {
            $list_sessions = $this->repository->findWhere(['is_completed' => 1, 'teacher_id' => Auth::user()->teacher->id])->groupBy('id');
        }
        elseif (Auth::user()->profile_type->name == "student") {
            $list_sessions = Auth::user()->student->sessions->filter(function($key, $session) {
                return $session->is_completed == 1;
            });
        }


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
            'uri' => "completed_sessions",
            'list_sessions' => $list_sessions,
            'total' => $total,
            'title' => trans('frontend.completed_sessions')
        ];

        return view($this->base_view . 'sessions.completedSessions', ['data' => array_merge($this->data, $data)]);
    }
    /**
     * List of canceled sessions
     */
    public function getCanceledSessions($id) {

        $list_sessions = $this->repository->findWhere(['is_canceled' => 1, 'teacher_id' => Auth::user()->teacher->id])->groupBy('id');

        $cancel_pen  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_cancel_penality'])->first()->content;

        $total = 0;

        foreach ($list_sessions as $key => $sessions) {
            $total_credit = $cancel_pen;

            $total += $total_credit;

            $list_sessions[$key]['total_credit'] = $total_credit;
        }

        $data = [
            'uri' => "canceled_sessions",
            'list_sessions' => $list_sessions,
            'title' => trans('frontend.canceled_sessions'),
            'total' => $cancel_pen
        ];

        return view($this->base_view . 'sessions.canceledSessions', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Mark a session as completed (passed) by the teacher
     * @param int $id
     */
    public function markAsCompleted($id) {

        $session = $this->repository->find($id);
        $teacher = $session->teacher;

        if (Auth::user()->profile_type->name != "admin" && ($teacher->id != Auth::user()->teacher->id || Auth::user()->is_blocked == 1)) {
            $response = [
                'success' => false,
                'message' => (Auth::user()->is_blocked == 1) ? trans('notifications.account_blocked') : trans('notifications.error_occured')
            ];

            return response()->json($response);
        }

        $profile_type = $this->repositories['ProfileTypesRepository']->findWhere(['name' => 'admin'])->first();
        $admin        = $this->repositories['UsersRepository']->findWhere(['profile_type_id' => $profile_type->id])->first();

        $session_per  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_percentage'])->first()->content;

        $this->repository->update(['is_completed' => 1], $id);

        // Withdraw credit from students to teacher and administration account
        $participedStudents = $session->students;

        foreach ($participedStudents as $student) {

            $admin->credit += (int)$session->credit_cost * ($session_per / 100);
            $teacher->user->credit += (int)$session->credit_cost * ((100 - $session_per) / 100);

            $teacher->user->total_hours += (int)$session->nbr_hours;

            $student->user->total_hours += (int)$session->nbr_hours;

            $student->push();
        }

        $admin->save();
        $teacher->push();

        $response = [
            'success' => true,
            'message' => trans('notifications.session_completed')
        ];

        return response()->json($response);
    }

    /**
     * Cancel a session.
     * @param integer $id
     */
    public function markAsCanceled($id) {
        $session = $this->repository->find($id);
        $teacher = $session->teacher;

        $cancel_pen  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_cancel_penality'])->first()->content;

        if (Auth::user()->profile_type->name != "admin" && ($teacher->id != Auth::user()->teacher->id || Auth::user()->is_blocked == 1)) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        $this->repository->update(['is_canceled' => 1], $id);

        // Decrease teacher credit (penality)
        /* $teacher->user->credit = (int)$teacher->user->credit - $cancel_pen;
        $teacher->push(); */

        foreach ($session->students as $student) {
            $student->user->credit += (int)$session->credit_cost;

            $student->push();
        }

        $response = [
            'success' => true,
            'message' => trans('notifications.session_canceled')
        ];

        return response()->json($response);
    }

    /**
     * Join a session
     * @param Request $request
     * @param int $îd
     */
    public function joinSession(Request $request, $id) {
        $session = $this->repository->find($id);
        $period = $session->period;

        $request->validate(['student_id' => 'required|numeric']);

        $user = $this->repositories['UsersRepository']->find($request->student_id);
        $student = $user->student;

        if (empty($student) || $user->profile_type->name != 'student') {
            throw new \LogicException('Unexpected student profile');
        }
        elseif ($user->is_blocked == 1) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        /* $dead_date = Carbon::createFromFormat('Y-m-d H:i', $period->date .' '. $period->hour_from);
        $now = Carbon::now(); */

        if (($session->students->count() < (int)$session->capacity)/*  && ($now->lte($dead_date)) */) {
           if ((int)$user->credit >= (int)$session->credit_cost) {
                $session->students()->attach($student);

                $user->credit = (int)$user->credit - (int)$session->credit_cost;
                $user->save();

                $response = [
                    'success' => true,
                    'message' => trans('notifications.session_joined')
                ];

                return response()->json($response);
            }
            else {
                $response = [
                    'success' => false,
                    'message' => trans('notifications.credit_insufficient')
                ];

                return response()->json($response);
            }
        }
        else {
            $response = [
                'success' => false,
                'message' => trans('notifications.attend_completed')
            ];

            return response()->json($response);
        }

    }

    /**
     *
     */
    public function exitFromSession(Request $request, $id) {
        $session = $this->repository->find($id);

        $request->validate(['student_id' => 'required|numeric']);

        $user = $this->repositories['UsersRepository']->find($request->student_id);
        $student = $user->student;

        if (empty($student) || $user->profile_type->name != 'student') {
            throw new \LogicException('Unexpected student profile');
        }
        elseif ($user->is_blocked == 1) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }


        $dead_date = Carbon::createFromFormat('Y-m-d', $session->date);
        $now = Carbon::now();

        // Check if the exiting day is the day before the session date (yesterday)
        if (/* $now->lt($dead_date) */ 1==1) {
            $session->students()->detach($student);

            $user->credit += (int)$session->credit_cost;
            $user->save();

            $response = [
                'success' => true,
                'message' => trans('notifications.exited_from_session')
            ];

            return response()->json($response);
        }

        $response = [
            'success' => false,
            'message' => trans('notifications.error_occured')
        ];

        return response()->json($response);
    }

    public function getSessionRules() {
        return [
            'title_fr' => 'required',
            'desc_fr'  => 'required',
            'objectives_fr' => 'required',
            'link'  => 'required|url',
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
            'link'  => 'required|url',
            'teacher_id' => 'required|numeric',
            'module_id' => 'required|numeric',
            'study_year_id' => 'required|numeric'
        ];
    }
}
