<?php

namespace App\Http\Controllers\Frontend\Sessions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\OpeningHours\OpeningHours;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

use App\SaidTech\Traits\Data\businessHoursTrait as businessHours;


class SessionsController extends FrontendBaseController
{
    use businessHours;

    /**
     * @var SessionRepository
     */

    protected $repository;

    public function __construct(
        SessionRepository $repository,
        UserRepository $userRepository,
        StudentRepository $studentRepository,
        ProfileTypeRepository $profileTypesRepository,
        ConfigRepository $configRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['StudentsRepository'] = $studentRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;

        $this->setRubricConfig('sessions');
    }

    /**
     * Show all teachers with actions
     */
    public function index() {
        $data = [
            'list_sessions' => $this->repository->findWhere(['is_completed' => 0, 'is_canceled' => 0])->all()->filter(function($session) {

                $d1 =  Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->first()->hour_from);
                $now = Carbon::now();

                return $now->lte($d1);
            }),
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($slug) {
        $data = [
            'session' => $this->repository->findWhere(['slug' => $slug])->first()
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Redirect to create view
     */
    public function create() {
        $data =  [
            'business_hours' => $this->getBusinessHours()
        ];

        return view($this->base_view . 'create', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Store a new Session
     * @param Request $request
     */
    public function store(Request $request) {
        $session = $request->validate($this->getSessionRules());

        $teacher = $this->repositories['TeacherRepository']->find($request->teacher_id)->first();

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

        $group_price  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => "group_price"])->first()->content;

        // Session credit cost calculate
        $session['credit_cost'] = (int)$session->nbr_hour * $group_price;

        $this->repository->create($session);

        $response = [
            'success' => true,
            'message' => trans('notifications.session_created')
        ];

        return redirect()->route('frontend.sessions.index')->with($response);
    }

    /**
     * Edit a session
     * @param int $id
     */
    public function edit($id) {
        $data = [
            'session' => $this->repository->find($id),
            'business_hours' => $this->getBusinessHours()
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }


    /**
     * Update an existing Session
     * @param Request $request
     */
    public function update(Request $request, $id) {
        $oldSession = $this->repository->find($id)->first();
        $session = $request->validate($this->getSessionRules());

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

        $this->repository->update($session, $id);

        $response = [
            'success' => true,
            'message' => trans('notifications.session_updated')
        ];

        return redirect()->route('frontend.sessions.index')->with($response);
    }

    /**
     * Mark a session as completed (passed) by the teacher
     * @param int $id
     */
    public function markAsCompleted($id) {
        $session = $this->repository->find($id)->first();
        $teacher = $session->teacher;

        if (Auth::user()->profile_type->name != "admin" && ($teacher->id != Auth::user()->teacher->id || Auth::user()->is_blocked == 1)) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        $profile_type = $this->repositories['ProfileTypeRepository']->findWhere(['name' => 'admin'])->first();
        $admin        = $this->repositories['UserRepository']->findWhere(['profile_type_id' => $profile_type->id])->first();

        $session_per  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => 'session_percentage'])->first()->content;

        $this->repository->update(['is_completed' => 1], $id);

        // Withdraw credit from students to teacher and administration account
        $participedStudents = $session->students;

        $admin->credit += (int)$session->credit_cost * ($session_per / 100);
        $teacher->user->credit += (int)$session->credit_cost * ((100 - $session_per) / 100);

        $teacher->user->total_hours += (int)$session->nbr_hours;

        $admin->save();
        $teacher->push();

        foreach ($participedStudents as $student) {
            $student->user->total_hours += (int)$session->nbr_hours;

            $student->push();
        }

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

        if (Auth::user()->profile_type->name != "admin" && ($teacher->id != Auth::user()->teacher->id || Auth::user()->is_blocked == 1)) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        $this->repository->update(['is_canceled' => 1], $id);

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
        $session = $this->repository->find($id)->first();

        $request->validate(['student_id' => 'required|numeric']);

        $student = $this->repositories['StudentsRepository']->find($request->student_id)->first();

        if (empty($student)) {
            throw new \LogicException('Unexpected student profile');
        }
        elseif ($student->is_blocked == 1) {
            $response = [
                'success' => false,
                'message' => trans('notifications.account_blocked')
            ];

            return response()->json($response);
        }

        if (($session->students->count() < (int)$session->capacity) && (Carbon::now() < $session->date)) {
           if ($student->credit <= $session->credit_cost) {
                $session->students()->attach($student);

                $student->user->credit = (int)$student->user->credit - (int)$session->credit_cost;
                $student->push();

                $response = [
                    'success' => true,
                    'message' => trans('notifications.session_joined')
                ];
            }
            else {
                $response = [
                    'success' => false,
                    'message' => trans('notifications.credit_insufficient')
                ];
            }
        }
        else {
            $response = [
                'success' => false,
                'message' => trans('notifications.attend_completed')
            ];
        }


        return redirect()->route('frontend.sessions.show', ['id' => $id])->with($response);

    }

    public function exitFromSession(Request $request, $id) {
        $session = $this->repository->find($id)->first();

        $request->validate(['student_id' => 'required|numeric']);

        $student = $this->repositories['StudentsRepository']->find($request->student_id)->first();

        if (empty($student)) {
            throw new \LogicException('Unexpected student profile');
        }

        $sessionDate = Carbon::createFromFormat('d/m/Y', $session->date->format('d/m/Y'));

        $yesterday = Carbon::createFromFormat('d/m/Y', Carbon::createFromTimestamp(strtotime('yesterday'))->format('d/m/Y'));

        $now = Carbon::createFromFormat('d/m/Y', Carbon::now()->format('d/m/Y'));;

        if (empty($student)) {
            throw new \LogicException('Unexpected student profile');
        }

        // Check if the exiting day is the day before the session date (yesterday)
        if ($yesterday->lte($now)) {
            $session->students()->detach($student);

            $student->user->credit += (int)$session->credit_cost;
            $student->push();

            $response = [
                'success' => true,
                'message' => trans('notifications.exited_from_session')
            ];

            return redirect()->route('frontend.sessions.show', ['id' => $id])->with($response);
        }
        $response = [
            'success' => false,
            'message' => trans('notifications.error_occured')
        ];

        return response()->json($response);
    }

    public function getSessionRules() {
        return [
            'title' => 'required',
            'desc'  => 'nullable',
            'date' => 'required|date',
            'hour_from' => 'required',
            'hour_to' => 'required',
            'teacher_id' => 'required|numeric',
        ];
    }
}
