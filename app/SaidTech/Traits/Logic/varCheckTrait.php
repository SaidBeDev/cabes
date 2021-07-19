<?php

namespace App\SaidTech\Traits\Logic;

trait varCheckTrait
{

    public function isBoolean($var) {
        $is_boolean = ($var == 0 || $var == 1 || $var == false || $var == true) ? true : false;

        return $is_boolean;
    }
}
