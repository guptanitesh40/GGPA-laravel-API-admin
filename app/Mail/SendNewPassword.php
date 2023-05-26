<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $new_password;

    public function __construct($name, $email, $new_password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->new_password = $new_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Admin : New password for '.$this->name)
            ->view('email.new-password')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'new_password' => $this->new_password,
            ]);   
        return $mail;
    }
}
