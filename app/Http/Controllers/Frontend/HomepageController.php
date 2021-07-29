<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Module;
use App\StudyYear;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\SaidTech\Traits\Auth\RegisterTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Controllers\Frontend\FrontendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;


use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;

class HomepageController extends FrontendBaseController
{
    use RegisterTrait;

     /**
     * @var TeacherRepository
     */

    protected $repository;

    public function __construct(
        UserRepository $userRepository,
        ProfileTypeRepository $profileTypesRepository,
        ModuleRepository $moduleRepository,
        SessionRepository $sessionRepository,
        StudyYearRepository $stdYearRepository
    )
    {
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['SessionRepository'] = $sessionRepository;
        $this->repositories['stdYearRepository'] = $stdYearRepository;

        $this->setRubricConfig('homepage');
    }

    public function index() {
       /*  $m = [

        ];

        $trans = [
            'fr' => [
                'name' => "5e année universitaire"
            ],
            'ar' => [
                'name' => "السنة الخامسة جامعي"
            ]
        ];

        $res = $this->repositories['stdYearRepository']->create(array_merge($m, $trans));

        dd($res);
 */
        $data = [
            'list_teachers' => $this->repositories['UsersRepository']->whereHas('profile_type', function(Builder $query){
                $query->where('name', '=', 'teacher');
            })->all(),
            'list_sessions' => $this->repositories['SessionRepository']->orderBy('date', 'DESC')->findWhere(['is_canceled' => 0, 'is_completed' => 0])->filter(function($session) {

                $d1 =  Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->first()->hour_from);
                $now = Carbon::now();

                return $now->lte($d1);
            }),
            'list_modules' => Module::with('translations')->get()->sortBy(function($module) {
                return $module->teachers->count();
            }, SORT_REGULAR, true)->filter(function($module) {
                return $module->teachers->count() != 0;
            })
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

}
