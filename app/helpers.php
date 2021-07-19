<?php

use Carbon\Carbon;


function getSessionLen($session) {
    if (!empty($session)) {
        if ($session->periods->count() == 1) {
            $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
            $d2 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_to);

        }elseif($session->periods->count() == 2) {
            $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
            $d2 = Carbon::createFromFormat('H:i', $session->periods->last()->hour_to);
        }

        return $d2->diffInRealHours($d1);

    }

    return false;
}

/**
 * Calculate the difference between two hours
 */
function getDiffHours($h) {
    $d1 = Carbon::createFromFormat('H:i', $h);
    $now = Carbon::now();

}

/**
 * Calculate the time since announce was published
 *
 * @param Date $published_start_at
 *
 * @return string
 */
function getSincePublished($published_start_at)
{
    $today     = Carbon\Carbon::now();
    $diffTotal = 0;

    if (!isset($published_start_at)) {
        throw new LogicException('Published at date is not entered');
    } else {
        if ($today->diffInYears($published_start_at) > 0) {
            $diffTotal = trans('frontend.since_pub_years');
        } elseif ($today->diffInMonths($published_start_at) != 0) {
            $diffTotal = trans('frontend.since_pub_months', ['t' => $today->diffInMonths($published_start_at)]);

            if ($today->diffInMonths($published_start_at) < 2) {
                $diffTotal = trans('frontend.since_one_month');
            }
        } elseif ($today->diffInDays($published_start_at) != 0) {
            $diffTotal = trans('frontend.since_pub_days', ['t' => $today->diffInDays($published_start_at)]);

            if ($today->diffInDays($published_start_at) < 2) {
                $diffTotal = trans('frontend.since_one_day');
            }
        } elseif ($today->diffInHours($published_start_at) != 0) {
            $diffTotal = trans('frontend.since_pub_hours', ['t' => $today->diffInHours($published_start_at)]);

            if ($today->diffInHours($published_start_at) < 2) {
                $diffTotal = trans('frontend.since_one_hour');
            }
        } elseif ($today->diffInMinutes($published_start_at) != 0) {
            $diffTotal = trans('frontend.since_published', ['t' => $today->diffInMinutes($published_start_at)]);

            if ($today->diffInMinutes($published_start_at) < 2) {
                $diffTotal = trans('frontend.since_one_minute');
            }
        } elseif ($today->diffInMinutes($published_start_at) == 0) {
            $diffTotal = trans('frontend.since_one_minute');
        }
    }

    return $diffTotal;
}
