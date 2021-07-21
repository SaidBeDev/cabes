<?php

namespace App\Http\Controllers\Frontend\Profile;

use Auth;
use App\Shedule;
use App\Statuses;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\SaidTech\Traits\Auth\RegisterTrait;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Traits\Files\UploadImageTrait as UploadImage;
use App\SaidTech\Repositories\DairasRepository\DairaRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\PeriodsRepository\PeriodRepository;
use App\SaidTech\Repositories\WilayasRepository\WilayaRepository;
use App\SaidTech\Traits\Data\businessHoursTrait as businessHours;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\TeachersRepository\TeacherRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class TeacherProfileController extends FrontendBaseController
{
    use UploadImage, RegisterTrait, businessHours;

    /**
     * @var UserRepository
     */

    protected $repository;

    public function __construct(
        UserRepository $repository,
        StudentRepository $studentRepository,
        TeacherRepository $teacherRepository,
        ProfileTypeRepository $profileTypesRepository,
        ConfigRepository $configRepository,
        WilayaRepository $wilayaRepository,
        DairaRepository $dairaRepository,
        PeriodRepository $periodsRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['StudentRepository'] = $studentRepository;
        $this->repositories['TeacherRepository'] = $teacherRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['WilayasRepository'] = $wilayaRepository;
        $this->repositories['DairasRepository'] = $dairaRepository;
        $this->repositories['PeriodsRepository'] = $periodsRepository;

        $this->setRubricConfig('profile');
    }


    /**
     * Change teacher weekly planning
     */
    public function editAvailability($id) {
        if (Auth::user()->id != $id) {
            throw new \LogicException('Action pas autorisée');
        }

        $user = $this->repository->find($id);

        $data = [
            'uri' => "",
            'title' => trans('menu.edit_availability'),
            'user' => $user,
            'list_status' => Statuses::all(),
            'list_periods' => $this->repositories['PeriodsRepository']->all()
        ];

        return view($this->base_view . 'teacher.editAvailability', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Change teacher weekly planning
     */
    public function updateAvailability(Request $request , $id) {
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $list_periods = $this->repositories['PeriodsRepository']->all();

        if (Auth::user()->id != $id) {
            throw new \LogicException('Action pas autorisée');
        }

        $user = $this->repository->find($id);

        if (empty($user->teacher)) {
            throw new \LogicException('Unexpected profile type');
        }

        Shedule::where('teacher_id', $user->teacher->id)->where('status_id', '<>', '3')->delete();

        for ($i = 0; $i < count($days); $i++) {
            if (isset ($request->all()[$days[$i]])) {
                for ($j = 0; $j < count($request->all()[$days[$i]]); $j++) {
                    $sh = [
                        'period_id' => $request->all()[$days[$i]][$j],
                        'status_id' => 1,
                        'teacher_id' => $user->teacher->id,
                        'uri' => 0,
                        'day' => $days[$i],
                        'date' => Carbon::createFromTimestamp(strtotime('next '.$days[$i]))->format('Y-m-d')
                    ];

                    Shedule::create($sh);

                }
            }
        }

        $response = [
            'success' => true,
            'message' => trans('notifications.availability_updated')
        ];

        return redirect()->route('frontend.profile.editAvailability', ['id' => $user->id])->with($response);
    }

    public function isContainPeriod($id) {
        $user = $this->repository->find(Auth::user()->id);

        foreach ($user->teacher->shedules as $shedule) {

        }
    }
}
