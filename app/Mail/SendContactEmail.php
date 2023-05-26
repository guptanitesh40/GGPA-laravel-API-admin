<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $comment;
    public $filename;

    public function __construct($name, $email, $comment, $filename = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->comment = $comment;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Important! new message from GGPA by '.$this->name)
            ->view('email.contact-us-from')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'comment' => $this->comment,
            ]);    
            return $mail;
    }
}
