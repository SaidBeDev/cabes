<?php

namespace App\SaidTech\Traits\Auth;

use Illuminate\Support\Facades\Mail;

trait ContactTrait
{

    /**
     * Send contact Email
     */

    public function sendContactMail($data) {

        $res = Mail::send('emails.contactEmail', ['data' => $data],
            function ($mail) use ($data) {
                $mail->from($data['email'], "CABES");
                $mail->to('contact@cabesacademy.org');
                $mail->subject($data['subject']);
            });

        return $res;

    }
}
