<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Frontend\FrontendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class SessionsController extends FrontendBaseController
{

     /**
     * @var SessionRepository
     */

    protected $repository;

    public function __construct(
        UserRepository $userRepository,
        ProfileTypeRepository $profileTypesRepository,
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        SessionRepository $sessionRepository
    )
    {
        $this->repositories['UsersRepository'] = $userRepository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;

        $this->repository = $sessionRepository;

        $this->setRubricConfig('sessions');
    }

    public function index() {

        $data = [
            'list_sessions' => $this->repository->findWhere(['is_completed' => 0, 'is_canceled' => 0])->filter(function($session) {

                $d1 =  Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->first()->hour_from);
                $now = Carbon::now();

                return $now->lte($d1);
            })
        ];


        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function getByModule($slug) {
        $this->slug = $slug;

        $module = $this->repositories['ModulesRepository']->whereHas('translations', function(Builder $query) {
            $query->where('slug', $this->slug);
        })->first();

        $translatedSlug = [
            'fr' => trans('routes.by_module', [], 'fr') .'/'. $module->translate('fr')->slug,
            'ar' => trans('routes.by_module', [], 'ar') .'/'. $module->translate('ar')->slug
        ];

        $this->generateRouteCustom(null, $translatedSlug);

        $data = [
            'list_sessions' => $module->sessions->filter(function($session) {
                return $session->is_completed == 0 && $session->is_canceled == 0;
            })
            ->filter(function($session) {

                $d1 =  Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->first()->hour_from);
                $now = Carbon::now();

                return $now->lte($d1);
            }),
            'title' => trans('frontend.find_session')
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function getByYear($slug) {
        $this->slug = $slug;

        $year = $this->repositories['StudyYearsRepository']->whereHas('translations', function(Builder $query) {
            $query->where('slug', $this->slug);
        })->first();

        $translatedSlug = [
            'fr' => trans('routes.by_year', [], 'fr') .'/'. $year->translate('fr')->slug,
            'ar' => trans('routes.by_year', [], 'ar') .'/'. $year->translate('ar')->slug
        ];

        $this->generateRouteCustom(null, $translatedSlug);

        $data = [
            'list_sessions' => $year->sessions->filter(function($session) {
                return $session->is_completed == 0 && $session->is_canceled == 0;
            }),
            'title' => trans('frontend.find_session')
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($slug) {

        $this->slug = $slug;

        $session = $this->repository->whereHas('translations', function(Builder $query) {
            $query->where('slug', $this->slug);
        })->first();

        $info = [
            'title' => $session->title
        ];

        $this->generateArticleRoutesWithSlug(null, $session);

        $data = [
           'session' => $session
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data, $info)]);
    }

}
