<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $code;

    public function __construct($name, $email, $code)
    {
        $this->name = $name;
        $this->email = $email;
        $this->code = $code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Admin : Reset password for '.$this->name)
            ->view('email.forgot-password')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'code' => $this->code,
            ]);   
        return $mail;
    }
}
