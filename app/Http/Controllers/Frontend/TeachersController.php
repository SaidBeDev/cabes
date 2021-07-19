<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\SessionsRepository\SessionRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class TeachersController extends FrontendBaseController
{

     /**
     * @var TeacherRepository
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
        $this->repositories['SessionRepository'] = $sessionRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;

        $this->setRubricConfig('teachers');
    }

    public function index() {

        $data = [
            'list_teachers' => $this->repositories['UsersRepository']->whereHas('profile_type', function(Builder $query){
                $query->where('name', '=', 'teacher');
            })->all(),
            'title' => trans('frontend.find_tutor')
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function show($id) {

        $data = [
            'user' => $this->repositories['UsersRepository']->find($id)
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }

    public function getByModule($slug) {
        $this->slug = $slug;

        $module = $this->repositories['ModulesRepository']->whereHas('translations', function(Builder $query) {
            $query->where('slug', $this->slug);
        })->first();

        $list_teachers = [];

        foreach ($module->teachers as $teacher) {
            array_push($list_teachers, $teacher->user);
        }

        $data = [
            'list_teachers' => $list_teachers,
            'title' => trans('frontend.find_tutor')
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

    public function getByYear($slug) {

        $year = $this->repositories['StudyYearsRepository']->whereHas('translations', function(Builder $query) {
            $query->where('slug', $this->slug);
        })->first();

        $list_teachers = [];

        foreach ($year->teachers as $teacher) {
            array_push($list_teachers, $teacher->user);
        }


        $data = [
            'list_teachers' => $list_teachers,
            'title' => trans('frontend.find_tutor')
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }

}
