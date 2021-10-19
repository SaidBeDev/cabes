<?php

namespace App\SaidTech\Traits\Auth;

use Illuminate\Support\Facades\Mail;

trait ContactTrait
{

    /**
     * Send contact Email
     */

    public function sendContactMail($data) {
        $subject = !empty($data['subject']) ? trans('frontend.contact_email') : $data['subject'];

        $res = Mail::send('emails.contactEmail', ['data' => $data],
            function ($mail) use ($data, $subject) {
                $mail->from($data['email'], "CABES");
                $mail->to('contact@cabesacademy.org');
                $mail->subject($subject);
            });

        return $res;

    }
}
