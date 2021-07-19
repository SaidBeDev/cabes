<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\SaidTech\Traits\Logic\varCheckTrait as varCheck;

class FrontendBaseController extends Controller
{
    /**
     * Traits
     */
    use varCheck;

    // Initializing variables
    public $rubric_uri = null;
    public $rubric_name = null;
    protected $base_view = null;
    protected $title = null;
    public $data = [];

    protected $where = null;
    protected $value = null;
    protected $model = [];
    protected $repositories = [];


    public function setRubricConfig($rubric_name) {

        $this->base_view   = 'frontend.rubrics.' . $rubric_name . '.';
        $this->rubric_name = $rubric_name;
        $this->rubric_uri  = trans('routes.' . $rubric_name);
        $this->title       = trans('menu.' . $rubric_name);

        $this->data = [
            'title' => $this->title
        ];
    }
}
