<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Kode OTP Reset Password')
                    ->html("
                        <h3>Halo!</h3>
                        <p>Anda meminta reset password.</p>
                        <p>Kode OTP Anda adalah: <b style='font-size:24px'>{$this->otp}</b></p>
                        <p>Kode ini berlaku selama 5 menit.</p>
                    ");
    }
}