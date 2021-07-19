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
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
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
        ConfigRepository $configRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;

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
}
