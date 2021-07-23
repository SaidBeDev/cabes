<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\StudyYear;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Module;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;


use App\SaidTech\Traits\Auth\RegisterTrait;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

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
        SessionRepository $sessionRepository
    )
    {
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['SessionRepository'] = $sessionRepository;

        $this->setRubricConfig('homepage');
    }

    public function index() {
        /* $user = Sentinel::findById(Auth::user()->id);
        $act = Activation::completed($user);

         $res = $this->sendConfirmMail($user, $act->code); */

        $data = [
            'list_teachers' => $this->repositories['UsersRepository']->whereHas('profile_type', function(Builder $query){
                $query->where('name', '=', 'teacher');
            })->all(),
            'list_sessions' => $this->repositories['SessionRepository']->findWhere(['is_canceled' => 0, 'is_completed' => 0])->all(),
            'list_modules' => Module::with('translations')->get()->sortBy(function($module) {
                return $module->teachers->count();
            }, SORT_REGULAR, true)
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

}
