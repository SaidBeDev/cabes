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
        $subject = 'Email de confirmation';

        $data = [
            'name' => $user->full_name,
            'user_id' => $user->id,
            'profile_type' => $user->profile_type->name,
            'code' => $code
        ];

        $res = Mail::send('emails.confirmEmail', ['data' => $data],
            function ($mail) use ($user, $subject) {
<<<<<<< HEAD
                $mail->from(getenv('MAIL_FROM_ADDRESS', 'noreplay@cabesacademy.org'), "CABES");
=======
                $mail->from(getenv('MAIL_FROM_ADDRESS'), "CABES");
>>>>>>> 96e797dd5a4c958f9f4d9fe423e26b466ac0273c
                $mail->to($user->email, $user->full_name);
                $mail->subject($subject);
            });

        return $res;

    }
}
