<?php

namespace App\Http\Controllers\Frontend;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\Controller;

use App\SaidTech\Traits\Logic\varCheckTrait as varCheck;
use App\SaidTech\Traits\Lang\routeTrait;

class FrontendBaseController extends Controller
{
    /**
     * Traits
     */
    use varCheck, routeTrait;

    // Initializing variables
    protected $rubric_uri = null;
    protected $rubric_name = null;
    protected $base_view = null;
    protected $title = null;
    public $data = [];
    public $uris = [];

    protected $repositories = [];


    public function setRubricConfig($rubric_name) {

        $this->base_view   = 'frontend.rubrics.' . $rubric_name . '.';
        $this->rubric_name = $rubric_name;
        $this->rubric_uri  = trans('routes.' . $rubric_name);
        $this->title       = trans('menu.' . $rubric_name);

        $this->generateTranslatedURL();

        $this->data = [
            'title' => $this->title,
            'uris'  => $this->uris
        ];
    }


}
