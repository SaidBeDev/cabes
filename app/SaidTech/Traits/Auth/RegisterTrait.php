<?php

namespace App\SaidTech\Traits\Auth;

use Illuminate\Support\Facades\Mail;

trait RegisterTrait
{
    public function getAvailabilityStatus() {
        return collect([
            (object) [
                'name' => 'occupied',
                'color' => 'grey'
            ],
            (object) [
                'name' => 'available',
                'color' => 'green'
            ],
            (object) [
                'name' => 'not_decised',
                'color' => 'yellow'
            ],
            (object) [
                'name' => 'session',
                'color' => 'blue'
            ]
        ]);
    }


    /**
     * Send Confirmation Email
     */

    public function sendConfirmMail($user, $code) {
        $subject = trans('frontend.send_conf_email');

        $data = [
            'name' => $user->full_name,
            'user_id' => $user->id,
            'profile_type' => $user->profile_type->name,
            'code' => $code
        ];

        $res = Mail::send('emails.confirmEmail', ['data' => $data],
            function ($mail) use ($user, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS', 'noreplay@cabesacademy.org'), "CABES");
                $mail->to($user->email, $user->full_name);
                $mail->subject($subject);
            });

        return $res;

    }

    /**
     * Send Reset password mail
     */
    public function sendResetPassMail($user, $code) {
        $subject = trans('frontend.reset_pass');

        $data = [
            'name' => $user->full_name,
            'user_id' => $user->id,
            'profile_type' => $user->profile_type->name,
            'code' => $code
        ];

        $res = Mail::send('emails.resetPassword', ['data' => $data],
            function ($mail) use ($user, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS', 'noreplay@cabesacademy.org'), "CABES");
                $mail->to($user->email, $user->full_name);
                $mail->subject($subject);
            });

        return $res;

    }

    /**
     * Send User Guide
     */
    public function sendUserGuide($user) {

        $subject = 'دليل استخدام الموقع';

        $data = [
            'profile_type' => $user->profile_type->name
        ];

        $res = Mail::send('emails.userGuide', ['data' => $data],
            function ($mail) use ($user, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS', 'noreplay@cabesacademy.org'), "CABES");
                $mail->to($user->email, $user->full_name);
                $mail->subject($subject);
            });

        return $res;
    }
}
