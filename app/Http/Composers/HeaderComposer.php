<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;

class HeaderComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $modules;
    protected $study_years;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(ModuleRepository $modules, StudyYearRepository $study_years)
    {
        // Dependencies automatically resolved by service container...
        $this->modules = $modules;
        $this->study_years = $study_years;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $menu = [
            'list_modules' => $this->modules->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_modules'    => $this->modules->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),

            'spec_years' => $this->study_years->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),
            'study_years' => $this->study_years->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            })
        ];

        $view->with('menu', $menu);
    }
}
