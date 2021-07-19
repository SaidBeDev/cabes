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
        $subject = 'Email confirmation';

        $data = [
            'name' => $user->full_name,
            'user_id' => $user->id,
            'profile_type' => $user->profile_type->name,
            'code' => $code
        ];

        $res = Mail::send('emails.confirmEmail', ['data' => $data],
            function ($mail) use ($user, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), "CABES");
                $mail->to('noreplay@example.com', $user->full_name);
                $mail->subject($subject);
            });

        return $res;

    }
}