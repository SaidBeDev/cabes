<?php

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\OpeningHours\OpeningHours;

trait testTrait{

    protected $arr = [
        'monday'     => [
            ['09:30-11:00', 'data' => ['status' => 'available']]
        ],
        /* 'tuesday'    => ['09:00-12:00', '13:00-18:00'],
        'wednesday'  => ['09:00-12:00'],
        'thursday'   => ['08:00-09:30', '09:30-11:00', '13:00-18:00'],
        'friday'     => ['09:00-12:00', '13:00-20:00'],
        'saturday'   => ['09:00-12:00', '13:00-16:00'], */
        'sunday'     => []
    ];


    $new_arr = json_encode($arr, true);
    $s_arr  = json_decode($new_arr, true);

    $openingHours = OpeningHours::create($s_arr);

    $now = new DateTime('now');

    $text = '{
        "monday": "19:00",
        "data": {
            "color": "red"
        }
      }';

    $range = $openingHours->isOpenAt($now);

    $serialized = serialize($arr);

    /* dd(unserialize($serialized)); */

    $h1 = [
        'title' => "H1"
    ];
    $h2 = [
        'title' => "H2",
        'price' => "500"
    ];

    $a = '20:00:00';
    $b = Carbon::parse('21:30');
    $c = Carbon::parse($a);

    $credentials = [
        'full_name' => "Simane Kerrouchi",
        'email' => "kslimane11@gmail.com",
        'password' => Hash::make('123456'),
        'tel' => "0799093403",
        'address' => "dgddsgds",
        'gender' => "male",
        'birthday' => Carbon::createFromFormat('d/m/Y',  '17/02/1999'),
        'profile_type_id' => 2,
        'daira_id' => 222,
    ];

    $user = App\User::find(2);
    $student = App\StudentProfile::find(1);



    $date1 = Carbon::createFromFormat('d/m/Y', Carbon::createFromTimestamp(strtotime('yesterday'))->format('d/m/Y'));
    $date2 = Carbon::createFromFormat('d/m/Y', '01/02/2020');


    /* dd(\Carbon\Carbon::now()->floatDiffInHours(\Carbon\Carbon::createFromTimestamp($timestamp))); */
    dd(Carbon::now()->format('d/m/Y'));
    dd($date1->gt($date2));

}
