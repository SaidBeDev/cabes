<?php

namespace App\SaidTech\Traits\Data;

use Carbon\Carbon;

trait sessionsTrait
{

    public function getSessionLen($session) {
        if (!empty($session)) {
            if ($session->periods->count() == 1) {
                $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
                $d2 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_to);

            }elseif($session->periods->count() == 2) {
                $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
                $d2 = Carbon::createFromFormat('H:i', $session->periods->last()->hour_to);
            }

            return $d2->floatDiffInHours($d1);
        }

        return false;
    }
}
