<?php

namespace App\SaidTech\Traits\Data;

trait businessHoursTrait
{
    public function getBusinessHours() {
        $data = ['08:00', '09:30', '11:00', '12:30', '14:00', '15:30', '17:00', '18:30', '20:00', '21:30', '23:00'];

        return $data;
    }
    public function getBusinessPeriods() {
        $data = ['08:00-09:30', '9:30-11:00', '11:00-12:30', '12:30-14:00', '14:00-15:30', '15:30-17:00', '17:00-18:30', '18:30-20:00', '20:00-21:30', '21:30-23:00'];

        return $data;
    }

    public function getAvailableDays() {
        return [ "saturday", "sunday", "monday", "thursday", "wednesday", "tuesday", "friday" ];
    }
}
